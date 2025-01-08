#include <iostream>
#include <nlohmann/json.hpp>
using json = nlohmann::json;
class Solution {
    public:
        int twoSum(int num1,int num2) {
            return num1 + num2;
        }
    };
int main() {

      int num1 = 5;
      int num2 = 2;
      int num3 = 3;
      Solution solution;
      json j = solution.twoSum(num1,num2);
      std::cout << j << std::endl;
}