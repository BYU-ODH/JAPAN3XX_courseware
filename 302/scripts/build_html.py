"""Write html files for each lesson, taking content from
lessons.tsv (which strictly speaking is not really tabular, since
the first row of each lesson does not follow the column labels.

Usage: python3 build_html.py <tsv_file> <target_dir>
"""

import html
import os
import sys


try:
    src_tsv = sys.argv[1]
except IndexError:
    src_tsv = 'lessons.tsv'

try:
    target_dir = sys.argv[2].rstrip('/')
except IndexError:
    target_dir = 'generated_html'


with open('../common/lesson_front_matter.html') as f:
    lesson_front_matter = f.read().replace('3XX', '302')

with open('../common/main_front_matter.html') as f:
    main_front_matter = f.read().replace('3XX', '302')

def generate_lesson(rows):
    title_row, rows = rows[0], rows[1:]
    lesson, _, sound_file, title, unit = title_row
    with open(f'{target_dir}/{lesson}.html', 'w') as f:
        print(f'{lesson_front_matter}\n'
              f'        <span>{title}</span>\n'
               '      </a>\n'
               '    </li>\n'
               '  </ul>\n'
               '</nav>\n'
              f'  <div class="block title">{title}</div>\n'
               '  <hr>\n'
               '  <div class="block is-centered">\n'
               '    <p>\n'
               '      Listen to Whole Story <br>\n'
               '      <audio controls controlsList="nodownload">\n'
              f'        <source src="../{sound_file}" type="audio/mpeg">\n'
               '      </audio>\n'
               '      </a>\n'
               '    </p>\n'
               '  </div>\n'
               '  <table id="sentences" class="table-NOT"><tbody>\n',
              file=f)
        for row in rows:
            lesson, sent_id, sound_file, sent, trans, grammar_sent, vocab_sent, kanji_sent = row
            trans = trans.replace('"', '&quot;').replace("'", '&#39;')
            print(f'    <tr id="{sent_id}" class="sentence">\n'
                   '      <td class="has-text-centered" style="vertical-align: middle">\n'
                   '      <span class="icon is-clickable is-small" onclick="aud_play_pause(this)">\n'
                  f'        <i id="play_{sent_id}" class="fas fa-play"></i>\n'
                  f'        <audio id="audio_{sent_id}" onended="unplay(this.parentElement.getElementsByTagName(\'i\')[0])">\n'
                  f'          <source src="../sound/{sent_id}.mp3" type="audio/mpeg">\n'
                   '        </audio>\n'
                   '      </span>\n'
                   '      </td>\n'
                   '      <td>\n'
                  f'        <span class="content-sent grammar-sent is-hidden">{grammar_sent.strip() or sent}"</span>\n'
                  f'        <span class="content-sent kanji-sent is-hidden">{kanji_sent.strip() or sent}"</span>\n'
                  f'        <span class="content-sent plain-sent is-hidden">{sent}"</span>\n'
                  f'        <span class="content-sent vocab-sent">{vocab_sent.strip() or sent}"</span>\n'
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


def generate_main(lessons):
    current_unit = 0
    with open(f'{target_dir}/index.html', 'w') as f:
        print(main_front_matter, file=f)
        for unit, lesson, title in lessons:
            short_lesson = lesson.replace('lesson', '')
            if unit > current_unit:
                if current_unit != 0:
                    print('  </ul>', file=f)
                current_unit = unit
                print( '  <p class="menu-label">\n'
                      f'    Unit {unit}\n'
                       '  </p>\n'
                       '  <ul class="menu-list">\n',
                      file=f)

            print(f'    <li><a href="{lesson}.html">{short_lesson}: {title}</a></li>',
                  file=f)
        print('  </ul>\n'
              '</aside>\n'
              '</section>\n'
              '</body>\n',
              file=f)


lessons = []

with open(src_tsv) as f:
    col_labels = next(f).rstrip().split('\t')
    rows = []
    for row in f:
        row = row.rstrip().split('\t')
        if not rows:  # only very first row
            lesson, _, sound_file, title, unit = row
            unit = int(unit)
            lessons.append((unit, lesson, title))
            rows.append(row)
        elif row[1] == 'TITLE':
            generate_lesson(rows)
            lesson, _, sound_file, title, unit = row
            unit = int(unit)
            lessons.append((unit, lesson, title))
            rows = [row]
        else:
            rows.append(row)
    generate_lesson(rows)
generate_main(lessons)
