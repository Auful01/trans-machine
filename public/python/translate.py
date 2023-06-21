from deep_translator import GoogleTranslator
import sys
import nltk

txt = sys.argv[1]
arr = txt.split(".")

arrReturn = []

for i in arr:
    arrReturn.append(GoogleTranslator(
        source='auto', target='fr').translate(i) + ". ")
    # arrReturn.append(i)
# translator = GoogleTranslator(source='auto', target='fr')

print(arrReturn)
