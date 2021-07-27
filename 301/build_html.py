"""Write html files for each lesson, taking content from
xml.

Usage: python3 build_html.py <xml_file> <target_dir>
"""


import html
import json
import os
import re
import shutil
import sys

from bs4 import BeautifulSoup

try:
    src_xml = sys.argv[1]
except IndexError:
    src_xml = 'J301_LessonData.xml'

try:
    target_dir = sys.argv[2].rstrip('/')
except IndexError:
    target_dir = 'generated_html'
os.makedirs(target_dir, exist_ok=True)
for fname in ['bulma.min.css', 'translate.svg']:
    shutil.copy2(f'../common/{fname}', f'{target_dir}/{fname}')
for each_dir in ['fontawesome-free-5.15.3-web']:
    shutil.copytree(f'../common/{each_dir}', f'{target_dir}/{each_dir}', dirs_exist_ok=True)


with open('../common/lesson_front_matter.html') as f:
    lesson_front_matter = f.read().replace('3XX', '301')

with open('../common/main_front_matter.html') as f:
    main_front_matter = f.read().replace('3XX', '301')


def generate_lesson(lesson_soup):
    lesson = 'lesson' + lesson_soup['lessonNumber'].zfill(2)
    sound_file = lesson_soup.STORY['soundPath']
    title = lesson_soup.STORY['japaneseTitle']
    eng_title = lesson_soup.STORY['englishTitle']
    vocab_dict = {}
    for vocabulary in lesson_soup.find_all('VOCABULARY'):
        for link in vocabulary.find_all('LINK'):
            link_kanji = link.get_text().strip()
            vocab_dict[link_kanji] = (vocabulary['kanji'], vocabulary['kana'], vocabulary['english'])
    vocab_json = json.dumps(vocab_dict)
    grammar_dict = {}
    for grammar in lesson_soup.find_all('GRAMMAR'):
        gram_title = grammar['japanese']
        gram_explan = grammar['english']
        examples = [[re.sub(r'\s+', '', example.get_text()), example['translation']]
                    for example in grammar.find_all('EXAMPLE')]
        for link in grammar.find_all('LINK'):
            link_kanji = re.sub(r'\s+', '', link.get_text())
            grammar_dict[link_kanji] = [gram_title, gram_explan, examples]
    grammar_json = json.dumps(grammar_dict)
    kanji_dict = {}
    for kanji in lesson_soup.find_all('KANJI'):
        ji = kanji['ji']
        kun = kanji['kun']
        on = kanji['on']
        kanji_eng = kanji['english']
        link_kanji = kanji.LINK.get_text().strip()
        assert ji == link_kanji
        examples = [[example.get_text().strip(), example['translation']]
                    for example in kanji.find_all('EXAMPLE')]
        kanji_dict[ji] = [kun, on, kanji_eng, examples]
    kanji_json = json.dumps(kanji_dict)
    with open(f'{target_dir}/{lesson}.html', 'w') as f:
        print(f'{lesson_front_matter}\n'
              f'        <span>{title}</span>\n'
               '      </a>\n'
               '    </li>\n'
               '  </ul>\n'
               '</nav>\n'
              f'  <script>\n'
              f'  var vocab_json = {vocab_json};\n'
              f'  var grammar_json = {grammar_json};\n'
              f'  var kanji_json = {kanji_json};\n'
              f'  </script>\n'
              f'  <div class="block title">{title}</div>\n'
               '  <hr>\n'
               '  <div class="block is-centered">\n'
               '    <p>\n'
               '      Listen to Whole Story <br>\n'
               '      <audio controls controlsList="nodownload">\n'
              f'        <source src="{sound_file}" type="audio/mpeg">\n'
               '      </audio>\n'
               '      </a>\n'
               '    </p>\n'
               '  </div>\n'
               '  <p><b>Instructions: </b>Use the <i class="fas fa-play"></i> icon to play a sentence.\n'
               '                          Use the <i class="fas fa-language"></i> icon to show a translation.<br><br>\n'
               '  <table id="sentences" class="table-NOT"><tbody>\n',
              file=f)
        for line in lesson_soup.STORY.find_all('LINE'):
            sent_id_a, sent_id_b = re.search(r'^sound/(.*)-(.*)\.mp3$', line['soundPath']).groups()
            sent_id = f'{sent_id_a}-0{sent_id_b}'
            sound_file = f'sound/{sent_id}.mp3'
            sent = re.sub(r'\s+', '', line.LINK.get_text())
            trans = line['translation']
            trans = trans.replace('"', '&quot;').replace("'", '&#39;')
            vocab_sent = sent
            for kanji, (kanji2, kana, english) in vocab_dict.items():
                vocab_sent = vocab_sent.replace(kanji, f'''<a onclick="show_vocab_data('{kanji}')">{kanji}</a>''')
            grammar_sent = sent
            for kanji, (gram_title, gram_explan, examples) in grammar_dict.items():
                grammar_sent = grammar_sent.replace(kanji, f'''<a onclick="show_grammar_data('{kanji}')">{kanji}</a>''')
            kanji_sent = sent
            for kanji, (kun, on, kanji_eng, examples) in kanji_dict.items():
                kanji_sent = kanji_sent.replace(kanji, f'''<a onclick="show_kanji_data('{kanji}')">{kanji}</a>''')
            print(f'    <tr id="{sent_id}" class="sentence">\n'
                   '      <td class="has-text-centered" style="vertical-align: middle">\n'
                   '      <span class="icon is-clickable is-small" onclick="aud_play_pause(this)">\n'
                  f'        <i id="play_{sent_id}" class="fas fa-play"></i>\n'
                  f'        <audio id="audio_{sent_id}" onended="unplay(this.parentElement.getElementsByTagName(\'i\')[0])">\n'
                  f'          <source src="{sound_file}" type="audio/mpeg">\n'
                   '        </audio>\n'
                   '      </span>\n'
                   '      </td>\n'
                   '      <td>\n'
                  f'        <span class="content-sent grammar-sent is-hidden">{grammar_sent.strip() or sent}</span>\n'
                  f'        <span class="content-sent kanji-sent is-hidden">{kanji_sent.strip() or sent}</span>\n'
                  f'        <span class="content-sent plain-sent is-hidden">{sent}</span>\n'
                  f'        <span class="content-sent vocab-sent">{vocab_sent.strip() or sent}</span>\n'
                   '      </td>\n'
                   '    </tr>\n'
                   '    <tr class="is-clickable" onclick="show_hide_trans(this)">\n'
                   '      <td class="has-text-centered" style="vertical-align: middle">\n'
                  f'        <span class="icon">\n'
                  f'          <i class="fas fa-language"></i>\n'
                   '        </span>\n'
                   '      </td>\n'
                   '      <td>\n'
                  f'        <span class="trans is-invisible">{trans}</span>\n'
                   '      </td>\n'
                   '    </tr>\n',
                  file=f)
        print('  </tbody></table>\n'
              '  <nav class="navbar has-shadow is-fixed-bottom is-light is-spaced">\n'
              '      <div class="field has-addons">\n'
              '        <p class="control">\n'
              '          <button class="button is-primary mode-button vocab" onclick="change_mode(\'vocab\')">Vocab</button>\n'
              '        </p>\n'
              '        <p class="control">\n'
              '          <button class="button mode-button grammar" onclick="change_mode(\'grammar\')">Grammar</button>\n'
              '        </p>\n'
              '        <p class="control">\n'
              '          <button class="button mode-button kanji" onclick="change_mode(\'kanji\')">Kanji</button>\n'
              '        </p>\n'
              '    </div>\n'
              '  </nav>\n'
              '</section>\n'
              '</body>\n'
              '\n'
              '</html>\n', file=f)


def generate_main(soup):
    current_unit = 0
    with open(f'{target_dir}/index.html', 'w') as f:
        print(main_front_matter, file=f)
        for lesson in soup.find_all('LESSON'):
            unit = 1  # TODO add units to xml?
            short_lesson = lesson['lessonNumber'].zfill(2)
            full_lesson = 'lesson' + short_lesson
            title = lesson.STORY['japaneseTitle']
            eng_title = lesson.STORY['englishTitle']
            if unit > current_unit:
                if current_unit != 0:
                    print('  </ul>', file=f)
                current_unit = unit
                print( '  <p class="menu-label">\n'
                      f'    Unit {unit}\n'
                       '  </p>\n'
                       '  <ul class="menu-list">\n',
                      file=f)

            print(f'    <li><a href="{full_lesson}.html">Lesson {int(short_lesson)}: {title}</a></li>',
                  file=f)
        print('  </ul>\n'
              '</aside>\n'
              '</section>\n'
              '</body>\n',
              file=f)


with open(src_xml) as f:
    soup = BeautifulSoup(f, 'lxml-xml')
    generate_main(soup)
    for lesson in soup.find_all('LESSON'):
        generate_lesson(lesson)
