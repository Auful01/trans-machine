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

num_pages = reader.numPages

rest = ''

for p in range(num_pages):
    page = reader.getPage(p)
    text = page.extractText(0).encode('utf-8')
    results = text.decode('utf-8').replace(";", "ti")
    # rest += results
    strs = results.encode('utf-8')
    var = strs.decode('ascii', 'ignore')

    rest += var

res = ''
resTrans = ''
result = []
# print(rest)
doc = nlp(rest)

# print(doc)

idx = 0

for sent in doc.sents:
    res = res + (str(idx) + ":" + str(sent.text)) + ";"
    idx += 1

print(res)
# for page in range(num_pages):
#     text = page.get_text(sort=True)
#     print(text)
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
