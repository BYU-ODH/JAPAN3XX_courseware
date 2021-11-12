import sys

import xmlschema

xmlschema.validate(sys.argv[1], 'JAPANESECLASS.xsd')
