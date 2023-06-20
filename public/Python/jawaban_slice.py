import sys
import PyPDF2
import spacy
import fitz


nlp = spacy.load("en_core_web_sm")

file = open(
    '/Users/aufulkirom/Documents/KULIAH/SKRIPSI/translation-machine/public/storage/hasil/' + sys.argv[1], 'rb')

reader = fitz.open(file)


rest = ''
for page in reader:
    text = page.get_text(sort=True)
    rest += text.replace("Machine Translated by Google",
                         "").replace("\n", " ").replace(";", "")

res = ''
resTrans = ''
doc = nlp(rest)

idx = 0
for sent in doc.sents:
    res = res + str(idx) + ":" + str(sent.text) + ";"
    idx += 1
print(res)
