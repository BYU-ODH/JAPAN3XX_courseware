import re
import sys

with open(sys.argv[1]) as f:
    src = f.read()

src = re.sub(r'.*(<table.*</table>).*', r'\1', src, flags=re.S)
with open(sys.argv[1], 'w') as f:
    print(src, file=f)
