"""Run on content/ dir to make a tsv of only the text for each page."""

from glob import glob

from bs4 import BeautifulSoup
from tqdm import tqdm

with open('culture.tsv', 'w') as culture_file, \
     open('grammar.tsv', 'w') as grammar_file, \
     open('kanji.tsv', 'w') as kanji_file, \
     open('sound.tsv', 'w') as sound_file, \
     open('translation.tsv', 'w') as translation_file, \
     open('vocab.tsv', 'w') as vocab_file, \
     open('extract_err.tmp', 'w') as err_file:
    print('lesson', 'category', 'filename', 'content', sep='\t', file=translation_file)
    for full_path in tqdm(glob('**/*.htm*', recursive=True)):
        try:
            lesson, category, filename = full_path.split('/')
        except ValueError:
            print(full_path, file=err)
            continue
        with open(full_path) as f:
            soup = BeautifulSoup(f, 'lxml')
        content = soup.body.get_text(' ').strip()
        print(lesson, category, filename, content, sep='\t', file=tsv_file)
