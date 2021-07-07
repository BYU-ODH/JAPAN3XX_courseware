from glob import glob
import re

from bs4 import BeautifulSoup
from tqdm import tqdm


unit_dict = {'lesson01': 1,
             'lesson02': 1,
             'lesson03': 1,
             'lesson04a': 1,
             'lesson04b': 1,
             'lesson05': 2,
             'lesson06a': 2,
             'lesson06b': 2,
             'lesson07a': 2,
             'lesson07b': 2,
             'lesson08a': 3,
             'lesson08b': 3,
             'lesson09a': 3,
             'lesson09b': 3,
             'lesson10': 3,
             'lesson11a': 4,
             'lesson11b': 4,
             'lesson12a': 4,
             'lesson12b': 4,
             'lesson13a': 4,
             'lesson13b': 4,
             'lesson14a': 4,
             'lesson14b': 4,
             }


def rm_spaces(tag):
    print(tag, list(tag.strings), [s for s in tag.strings if ' ' in s])
    while any(' ' in s for s in tag.strings):
        for s in tag.strings:
            if ' ' in s:
                s.replace_with(s.replace(' ', ''))


def get_sent_by_sound_file_id(soup, sent_id):
    filtered_tags = []
    # rm_spaces(soup)
    for tag in soup.find_all('p'):
        try:
            if tag.a['href'].split('/')[-1].split('.')[0] == sent_id:
                filtered_tags.append(tag)
        except:
            pass
    
    if len(filtered_tags) == 1:
        tag = filtered_tags[0]
        tag.a.extract()  # remove the sound file link
        # rm_spaces(tag)
        sent = re.sub(r'\s+', ' ', tag.decode_contents()).strip()
        sent = re.sub(r'(?<=>) | (?=<)', '', sent)
        return sent
    else:
        return ''


with open('lessons.tsv', 'w') as trans_tsv_file:
    print('lesson', 'sent_id', 'sound_file', 'sent', 'trans', 'grammar_sent',
          'vocab_sent', 'kanji_sent', sep='\t', file=trans_tsv_file)
    for lesson_dir in tqdm(sorted(glob('content/lesson*'))):
        lesson = lesson_dir.split('/')[-1]
        with open(lesson_dir + '/translation.html') as trans_file:
            trans_soup = BeautifulSoup(trans_file, 'lxml')
        try:
            with open(lesson_dir + '/grammar.html') as grammar_file:
                grammar_soup = BeautifulSoup(grammar_file, 'lxml')
        except FileNotFoundError:
            grammar_soup = BeautifulSoup('', 'lxml')
        with open(lesson_dir + '/vocab.html') as vocab_file:
            vocab_soup = BeautifulSoup(vocab_file, 'lxml')
        with open(lesson_dir + '/kanji.html') as kanji_file:
            kanji_soup = BeautifulSoup(kanji_file, 'lxml')
        title = trans_soup.find('p', class_='heading').font.get_text(' ').strip()
        title = title.replace(': Translation', '')
        lesson_sound_file = trans_soup.div.p.a['href']
        unit = unit_dict[lesson]
        print(lesson, 'TITLE', lesson_sound_file, title, unit, '', '', '',
              sep='\t', file=trans_tsv_file)
        sentences = []
        for p in trans_soup.find_all('p', class_='sentence'):
            sound_file = p.a['href']
            sent_id = sound_file.split('/')[-1].split('.')[0]
            sent = p.get_text(' ').strip().replace('\n', '<br>')
            grammar_sent = get_sent_by_sound_file_id(grammar_soup, sent_id)
            grammar_sent = re.sub(r'''<a\s+href="javascript:getDesc\('grammar',\d+,(\d+)\)">\s*(.+?)\s*</a>''',
                                  r'''<a onclick="show('../grammar/\1.html')">\2</a>''',
                                  grammar_sent)
            vocab_sent = get_sent_by_sound_file_id(vocab_soup, sent_id)
            vocab_sent = re.sub(r'''<a\s+href="javascript:getDesc\('vocab',\d+,(\d+)\)">\s*(.+?)\s*</a>''',
                                r'''<a onclick="show('../vocab/\1.html')">\2</a>''',
                                vocab_sent)
            kanji_sent = get_sent_by_sound_file_id(kanji_soup, sent_id)
            kanji_sent = re.sub(r'''<a\s+href="javascript:getDesc\('kanji',\d+,(\d+)\)">\s*(.+?)\s*</a>''',
                                r'''<a onclick="show_gif('../kanji/\1.gif')">\2</a>''',
                                kanji_sent)

            # Retrieve translation
            trans_id = set(re.search(r'translation[\'"]\s*,\s*(\d+)\s*,\s*(\d+)\s*\)',
                                     p.find_all('a')[1]['href']).groups())
            assert len(trans_id) == 1, f'{lesson} {title} {sent_id} had {trans_id}.'
            trans_id = trans_id.pop()
            with open(f'{lesson_dir}/translation/{trans_id}.htm') as f:
                sent_trans_soup = BeautifulSoup(f, 'lxml')
            trans = sent_trans_soup.body.get_text('').strip()
            print(lesson, sent_id, sound_file, sent, trans, grammar_sent,
                  vocab_sent, kanji_sent, sep='\t', file=trans_tsv_file)
