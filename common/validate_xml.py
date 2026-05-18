from pathlib import Path
import sys

import xmlschema

xmlschema.validate(sys.argv[1], str(Path(__file__).parent / 'JAPANESECLASS.xsd'))
