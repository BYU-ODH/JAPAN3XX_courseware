import html
import re
import sys

from bs4 import BeautifulSoup

xml_str = ''


def get_lesson_number(lesson):
    return re.match(r'lesson0*(.+)$', lesson).group(1)


def clean_trans(trans):
    trans = html.escape(trans)
    trans = re.sub(r'\s{2,}', ' ', trans)
    return trans


def get_grammar_xml(grammar_links):
    grammar_xml = ''
    grammar_links_dict = {fname: [link for inner_fname, link in grammar_links
                                  if inner_fname == fname]
                          for fname, _ in grammar_links}
    for fname, links in grammar_links_dict.items():
        try:
            with open(f'generated_html/grammar/{fname}') as f:
                grammar_soup = BeautifulSoup(f, 'lxml')
        except FileNotFoundError:
            continue
        p_tags = grammar_soup.find_all('p')
        p0 = p_tags[0].get_text(' ').replace('\n', ' ')
        gram_japanese, gram_english = re.search(r'(.*?):(.*)', p0).groups()
        for br in p_tags[1].find_all('br'):
            br.replace_with('\n')
        examples = re.split(r'例\d+\.\s*', p_tags[1].get_text(' '))
        more_explanation = examples.pop(0)
        more_explanation = more_explanation.replace('Explanation:', '<br/><br/>')
        gram_english += more_explanation
        grammar_xml += f'<GRAMMAR japanese="{clean_trans(gram_japanese)}" english="{clean_trans(gram_english)}">'
        for ex in examples:
            ex += '\n'
            ex_content, translation = ex.split('\n', maxsplit=1)
            grammar_xml += f'<EXAMPLE translation="{translation.strip()}">{ex_content}</EXAMPLE>'
        for link in links:
            grammar_xml += f'<LINK>{link}</LINK>'
        grammar_xml += '</GRAMMAR>'
    return grammar_xml


def get_vocab_xml(vocab_links):
    vocab_xml = ''
    vocab_links_dict = {fname: [link for inner_fname, link in vocab_links
                                if inner_fname == fname]
                        for fname, _ in vocab_links}
    for fname, links in vocab_links_dict.items():
        with open(f'generated_html/vocab/{fname}') as f:
            vocab_soup = BeautifulSoup(f, 'lxml')
        p_tags = vocab_soup.find_all('p')
        parsed = p_tags[0].get_text('').strip().split()
        len_parsed = len(parsed)
        if len_parsed == 1:
            kanji = parsed[0]
            kana = 'MISSING KANA'
        elif len_parsed == 2:
            kanji, kana = parsed
        else:
            kanji = parsed[0]
            kana = 'TOO MUCH TO PARSE' + ' '.join(parsed[1:])
        english = p_tags[1].get_text('').replace('Definition:', '').strip()
        # TODO remove old_html_label
        vocab_xml += f'<VOCABULARY old_html_label="{fname}" kanji="{kanji}" kana="{kana}" english="{english}">'
        for link in links:
            vocab_xml += f'<LINK>{link}</LINK>'
        vocab_xml += '</VOCABULARY>'
    return vocab_xml


def get_kanji_xml(kanji_links):
    kanji_xml = ''
    kanji_links_dict = {fname: [link for inner_fname, link in kanji_links
                                if inner_fname == fname]
                        for fname, _ in kanji_links}
    for fname, links in kanji_links_dict.items():
        try:
            with open(f'generated_html/kanji/{fname}') as f:
                kanji_soup = BeautifulSoup(f, 'lxml')
        except FileNotFoundError:
            print(f'WARNING kanji/{fname} not found.')
            continue
        kanji = kanji_soup.img.get('alt', '').replace('Animation', '').strip()
        soup_text = re.sub(r' *\n+ *', '\n', kanji_soup.get_text(' ')).strip()
        soup_text = re.sub(r'\n+', '\n', soup_text)
        soup_split = soup_text.split()
        assert soup_split[:2] == ['音:', '訓:'], f'missing on and kun labels: {soup_split}'
        soup_split = soup_split[2:]
        assert 'Definition:' in soup_split, f'definition not detected: {soup_split}'
        def_idx = soup_split.index('Definition:')
        english = ' '.join(soup_split[def_idx+1:])
        soup_split = soup_split[:def_idx]
        if len(soup_split) < 2:
            print(f'WARNING kanji/{fname}: Not enough values to unpack for on and kun:', soup_split)
            on, kun = soup_split + ['']
        elif len(soup_split) == 2:
            on, kun = soup_split
        elif len(soup_split) > 2:
            on, kun, *extra = soup_split
            print(f'WARNING kanji/{fname}: Too many values to unpack for on and kun:', soup_split)
        else:
            raise OSError('Math is broken.')
        # english = re.search('Definition:.*?([A-Z; ]+)', kanji_soup.get_text(' '), re.S | re.M).group(1).strip()
        # td_tags = kanji_soup.find_all('td', valign='top')
        # for br in td_tags[1].find_all('br'):
        #     br.replace_with('\n')
        # orth_text = td_tags[1].get_text().strip()
        # orth_text_split = re.sub(r'\s{2,}', '\n', orth_text).split('\n')
        # try:
        #     on, kun, *extra = orth_text_split
        #     if extra:
        #         print(f'WARNING kanji/{fname}: Too many values to unpack for on and kun:', orth_text_split)
        # except ValueError:
        #     print(f'WARNING kanji/{fname}: Not enough values to unpack for on and kun:', orth_text_split)
        #     on, kun = orth_text_split + ['']
        # TODO remove old_html_label
        kanji_xml += f'<KANJI old_html_label="{fname}" ji="{kanji}" kun="{kun}" on="{on}" english="{english}">'
        for link in links:
            kanji_xml += f'<LINK>{link}</LINK>'
        kanji_xml += '</KANJI>'
    return kanji_xml


with open('lessons.tsv') as input_tsv:
    headers = next(input_tsv).rstrip().split('\t')
    xml_str += '<?xml version="1.0" encoding="UTF-8"?>'
    xml_str += '<JAPANESECLASS title="Japanese 302">'
    first_lesson = True
    vocab_links = []
    grammar_links = []
    kanji_links = []
    for line in input_tsv:
        parsed = line.rstrip().split('\t')
        if len(parsed) == 5:  # If this line starts a new lesson

            # Wrap up the last lesson
            if not first_lesson:
                xml_str += '</STORY>'
                xml_str += get_vocab_xml(vocab_links)
                xml_str += get_grammar_xml(grammar_links)
                xml_str += get_kanji_xml(kanji_links)
                xml_str += '</LESSON>'
            first_lesson = False
            vocab_links = []
            grammar_links = []
            kanji_links = []

            # Start new lesson
            lesson, TITLE, sound_file, title, unit = parsed
            sound_file = sound_file.replace('_', '-').replace('mov', 'mp3')
            xml_str += f'<LESSON lessonNumber="{get_lesson_number(lesson)}" unit="Unit {unit}">'
            xml_str += f'<STORY japaneseTitle="{title}" soundPath="{sound_file}">'
        elif len(parsed) == 8:  # If this is a sentence part of the lesson
            lesson, sent_id, sound_file, sent, trans, grammar_sent, vocab_sent, kanji_sent = parsed
            vocab_links.extend(re.findall(r'<a onclick="show\(\'\./vocab/(.+?\.html)\'\)">(.+?)</a>', vocab_sent))
            grammar_links.extend(re.findall(r'<a onclick="show\(\'\./grammar/(.+?\.html)\'\)">(.+?)</a>', grammar_sent))
            kanji_links.extend(re.findall(r'<a onclick="show\(\'\./kanji/(.+?\.html)\'\)">(.+?)</a>', kanji_sent))
            trans = clean_trans(trans)
            sent = re.sub(r'\s', '', sent)
            assert '"' not in sent and "'" not in sent
            sound_file = sound_file.replace('_', '-').replace('mov', 'mp3')
            xml_str += f'<LINE translation="{trans}" soundPath="{sound_file}">{sent}<LINK>{sent}</LINK></LINE>'
        else:
            raise ValueError(str(parsed))

soup = BeautifulSoup(xml_str, 'lxml-xml')
with open('302.xml', 'w') as f:
    print(soup.prettify(), file=f)
