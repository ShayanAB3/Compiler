import json
        class Test:
            def addTwoNum(a,b):
                return a+b

a = 5

b = 2
Test = Test()
print(json.dumps(Test.addTwoNum(a,b)))