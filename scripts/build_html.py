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


top_matter = '''<html>

<head>
  <title>
    Japanese 302
  </title>
  <meta content="width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=0" name="viewport"> 
  <meta content="text/html; charset=utf-8" http-equiv="Content-Type" />
  <link rel="stylesheet" href="../bulma.min.css">
  <link rel="stylesheet" href="../fontawesome-free-5.15.3-web/css/all.min.css">
<script>
function aud_play_pause(this_elem, elemId) {
    var myIcon = this_elem.getElementsByTagName("i")[0];
    var myAudio = this_elem.getElementsByTagName("audio")[0];
    if (myAudio.paused) {
        myIcon.classList.remove('fas', 'fa-play');
        myIcon.classList.add('fas', 'fa-pause');
        myAudio.play();
    } else {
        unplay(myIcon);
        myAudio.pause();
    }
}

function unplay(elem) {
    elem.classList.remove('fas', 'fa-pause');
    elem.classList.add('fas', 'fa-play');
}

function show_hide_trans(elem) {
    trans_elem = elem.getElementsByClassName('trans')[0];
    trans_style = getComputedStyle(trans_elem)
    if (trans_style['visibility'] == 'hidden') {
        trans_elem.style.visibility = 'visible';
    } else if (trans_style['visibility'] == 'visible') {
        trans_elem.style.visibility = 'hidden';
    } else {
        console.log('trans_elem has unexpected visibility style:')
        console.log(trans_elem)
        console.log(trans_elem.innerHTML)
    }
}

function change_mode(mode) {
    mode_buttons = document.getElementsByClassName('mode-button');
    for (let i = 0; i < mode_buttons.length; i++) {
        mode_buttons[i].classList.remove('is-primary')
    }
    document.getElementsByClassName(mode)[0].classList.add('is-primary')
    sents = document.getElementsByClassName('sent-content');
    for (let i = 0; i < sents.length; i++) {
        sents[i].innerHTML = sents[i].dataset[mode];
    }
}

function show(content_path) {
    modal_card_body = document.getElementById("modal-card-body");
    fetch(content_path)
        .then(response => response.text())
        .then(content_src => modal_card_body.innerHTML = content_src);
    modal_card = document.getElementById("modal-card");
    modal_card.classList.add("is-active");
}

function show_gif(gif_path) {
    var img = document.createElement("IMG");
    img.src = gif_path;
    document.getElementById('modal-content-img').appendChild(img);
    modal = document.getElementById("modal-img");
    modal.classList.add("is-active");
}

function close_modal() {
    modals = document.getElementsByClassName("modal");
    modals[0].classList.remove("is-active");
    modals[1].classList.remove("is-active");

    modal_card_body = document.getElementById("modal-card-body");
    modal_card_body.innerHTML = '';

    modal_content_img = document.getElementById("modal-content-img");
    modal_content_img.innerHTML = '';
}
</script>

<style>
.trans {
    visibility: hidden;
}

.sentence {
    border-top-color: gray;
    border-top-style: solid;
    border-top-width: thin;
}

nav.navbar.is-fixed-bottom > .field {
    justify-content: center;
}
</style>
</head>

<body class="has-navbar-fixed-bottom">

<div id="modal-card" class="modal">
  <div class="modal-background" onclick="close_modal()"></div>
  <div class="modal-card">
    <section id="modal-card-body" class="modal-card-body" onclick="close_modal()">
    </section>
  </div>
  <button class="modal-close is-large" aria-label="close" onclick="close_modal()"></button>
</div>

<div id="modal-img" class="modal">
  <div class="modal-background" onclick="close_modal()"></div>
  <p id="modal-content-img" class="image is-96x96" onclick="close_modal()"></p>
  <button class="modal-close is-large" aria-label="close" onclick="close_modal()"></button>
</div>


<nav class="breadcrumb" aria-label="breadcrumbs">
  <ul>
    <li>
      <a href="../index.html">
        <span class="icon is-small">
          <i class="fas fa-home" aria-hidden="true"></i>
        </span>
        <span>Home</span>
      </a>
    </li>
    <li class="is-active">
      <a href="#">
'''


def generate_lesson(rows):
    title_row, rows = rows[0], rows[1:]
    lesson, _, sound_file, title, unit = title_row
    os.makedirs(f'{target_dir}/{lesson}', exist_ok=True)
    with open(f'{target_dir}/{lesson}/index.html', 'w') as f:
        print(f'{top_matter}\n'
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
               '      <audio controls>\n'
              f'        <source src="../{sound_file}" type="audio/mpeg">\n'
               '      </audio>\n'
               '      </a>\n'
               '    </p>\n'
               '  </div>\n'
               '  <hr>\n'
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
                  f'      <span class="sent-content" data-grammar="{html.escape(grammar_sent.strip() or sent)}"\n'
                  f'                                   data-kanji="{html.escape(kanji_sent.strip() or sent)}"\n'
                  f'                                   data-vocab="{html.escape(vocab_sent.strip() or sent)}">\n'
                  f'        {vocab_sent}\n'
                   '      </span>\n'
                   '      </td>\n'
                   '    </tr>\n'
                   '    <tr class="is-clickable" onclick="show_hide_trans(this)">\n'
                   '      <td class="has-text-centered" style="vertical-align: middle">\n'
                  f'        <span class="icon">\n'
                  f'          <i class="fas fa-language"></i>\n'
                   '        </span>\n'
                   '      </td>\n'
                   '      <td>\n'
                  f'        <span class="trans">{trans}</span>\n'
                   '      </td>\n'
                   '    </tr>\n',
                  file=f)
        print('  </tbody></table>\n'
              '  <nav class="navbar is-fixed-bottom">\n'
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
              '</body>\n'
              '\n'
              '</html>\n', file=f)



main_front_matter = '''<html>

<head>
  <title>
    Japanese 302
  </title>
  <meta content="width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=0" name="viewport"> 
  <meta content="text/html; charset=utf-8" http-equiv="Content-Type" />
  <link rel="stylesheet" href="bulma.min.css">
  <link rel="stylesheet" href="fontawesome-free-5.15.3-web/css/all.min.css">
</head>
<body>
<span class="title">Japanese 302</span>
<hr>
<aside class="menu">
'''


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

            print(f'    <li><a href="{lesson}/index.html">{short_lesson}: {title}</a></li>',
                  file=f)
        print('  </ul>\n'
              '</aside>\n'
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
