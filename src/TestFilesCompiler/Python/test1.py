import json

class Test:
    def addTwoNum(self,a,b):
        return a+b

a = 5
b = 2
test = Test()
print(json.dumps(test.addTwoNum(a,b)))