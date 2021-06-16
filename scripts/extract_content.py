from glob import glob
import re

from bs4 import BeautifulSoup
from tqdm import tqdm


with open('translation.tsv', 'w') as trans_tsv_file:
    print('lesson', 'sent_id', 'sent', 'sound_file', 'trans', sep='\t', file=trans_tsv_file)
    for lesson_dir in tqdm(glob('content/lesson*')):
        lesson = lesson_dir.split('/')[-1]
        trans_dir = lesson_dir + '/translation/'
        with open(lesson_dir + '/translation.html') as trans_file:
            soup = BeautifulSoup(trans_file, 'lxml')
        title = soup.find('p', class_='heading').font.get_text(' ').strip()
        lesson_sound_file = soup.div.p.a['href']
        print(lesson, 'TITLE', title, '', lesson_sound_file, '', sep='\t', file=trans_tsv_file)
        sentences = []
        for p in soup.find_all('p', class_='sentence'):
            sound_file = p.a['href']
            sent_id = sound_file.split('/')[-1].split('.')[0]
            sent = p.get_text(' ').strip()

            # Retrieve translation
            trans_id = set(re.search(r'translation[\'"]\s*,\s*(\d+)\s*,\s*(\d+)\s*\)',
                                     p.find_all('a')[1]['href']).groups())
            assert len(trans_id) == 1, f'{lesson} {title} {sent_id} had {trans_id}.'
            trans_id = trans_id.pop()
            with open(f'{lesson_dir}/translation/{trans_id}.htm') as f:
                trans_soup = BeautifulSoup(f, 'lxml')
            trans = trans_soup.body.get_text(' ').strip()
            print(lesson, sent_id, sent, sound_file, trans, sep='\t', file=trans_tsv_file)
