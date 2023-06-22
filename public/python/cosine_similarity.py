# Program to measure the similarity between
# two sentences using cosine similarity.
from nltk.corpus import stopwords
from nltk.tokenize import word_tokenize
import sys
import json

# import nltk
# import ssl

# try:
#     _create_unverified_https_context = ssl._create_unverified_context
# except AttributeError:
#     pass
# else:
#     ssl._create_default_https_context = _create_unverified_https_context

# nltk.download('stopwords')

# nltk.download()
# X = input("Enter first string: ").lower()
# Y = input("Enter second string: ").lower()

test = sys.argv[1]
# tokenization
jawab = json.loads(test)
X_list = word_tokenize(jawab["jawaban"])
Y_list = word_tokenize(jawab["jawaban_benar"])

# sw contains the list of stopwords
sw = stopwords.words('english')
l1 = []
l2 = []

# # remove stop words from the string
Y_set = {w for w in Y_list if not w in sw}
X_set = {w for w in X_list if not w in sw and not w.index == len(Y_list) - 1}

# form a set containing keywords of both strings
rvector = X_set.union(Y_set)
for w in rvector:
    if w in X_set:
        l1.append(1)  # create a vector
    else:
        l1.append(0)
    if w in Y_set:
        l2.append(1)
    else:
        l2.append(0)
c = 0

# # cosine formula
for i in range(len(rvector)):
    c += l1[i]*l2[i]
    if float((sum(l1)*sum(l2))**0.5) != 0:
        cosine = c / float((sum(l1)*sum(l2))**0.5)
    else:
        cosine = 0
print(cosine)
