from glob import glob
import re

from bs4 import BeautifulSoup
from tqdm import tqdm

for filename in tqdm(glob('**/*.htm*', recursive=True)):
    with open(filename, 'rb') as f:
        bin_src = f.read()
    if len(bin_src.strip()) == 0:
        src = ''
    else:
        soup = BeautifulSoup(bin_src, 'lxml')
        src = soup.prettify()
        src = src.replace('\r', '')

    # elif b'Shift_JIS' in bin_src:
    #     src = bin_src.decode('shift_jis')
    #     src = re.sub('Shift_JIS', 'utf-8', src, flags=re.I)
    # elif b'iso-8859-1' in bin_src:
    #     src = bin_src.decode('utf-8')
    #     src = re.sub('iso-8859-1', 'utf-8', src, flags=re.I)
    # elif b'charset=macintosh' in bin_src:
    #     src = bin_src.decode('mac_roman')
    #     src = re.sub('macintosh', 'utf-8', src, flags=re.I)
    # else:
    #     print(f'{filename} has new encoding')
    #     print(re.findall(b'charset=".*?"', bin_src, flags=re.I))
    with open(filename, 'w') as f:
        f.write(src)
