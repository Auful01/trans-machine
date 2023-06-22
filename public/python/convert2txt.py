import sys
import PyPDF2
import spacy
from deep_translator import GoogleTranslator
# import fitz


from urllib.request import urlopen  # the lib that handles the url stuff
# from io import StringIO
import io

data = urlopen(sys.argv[1]).read()
# print(data)# it's a file like object and works just like a file
# for line in data: # files are iterable
#     print(line)

translator = GoogleTranslator(source='auto', target='en')


nlp = spacy.load("en_core_web_sm")

path = '/Users/aufulkirom/Documents/KULIAH/SKRIPSI/translation-machine/public/storage/asal/';

memoryFile = io.BytesIO(data)
# file = open(
#      data, 'rb')

reader = PyPDF2.PdfFileReader(memoryFile)


num_pages = reader.numPages

rest = [];

for p in range(num_pages):
    page = reader.getPage(p)
    text = page.extractText().encode('utf-8')
    # results = text.replace(";", "ti")
    # rest += results
    rest += text


print(rest)
res = ''
resTrans = ''
result = []
# print(rest.decode('utf-8'))
# doc = nlp(rest)


# idx = 0

# for sent in doc.sents:
#     trans = translator.translate(sent.text)
#     resTrans = resTrans + (str(idx) + ":" + str(trans)) + ";"
#     res = res + (str(idx) + ":" + str(sent.text)) + ";"
#     idx += 1

# print(res)
# print(resTrans)
