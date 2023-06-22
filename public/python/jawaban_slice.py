import sys
import PyPDF2
import spacy
import fitz
import io
from urllib.request import urlopen

data = urlopen(sys.argv[1]).read()

nlp = spacy.load("en_core_web_sm")

path ='/Users/aufulkirom/Documents/KULIAH/SKRIPSI/translation-machine/public/storage/hasil/'

memoryFile = io.BytesIO(data)

# file = open(
#       sys.argv[1], 'rb')

reader = PyPDF2.PdfFileReader(memoryFile)


rest = ''
for page in reader:
    text = page.get_text(sort=True)
    print(text)
#     rest += text.replace("Machine Translated by Google",
#                          "").replace("\n", " ").replace(";", "")

# res = ''
# resTrans = ''
# doc = nlp(rest)

# idx = 0
# for sent in doc.sents:
#     res = res + str(idx) + ":" + str(sent.text) + ";"
#     idx += 1
# print(res)
