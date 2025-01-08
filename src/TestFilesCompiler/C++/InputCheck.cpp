#include <iostream>
#include <nlohmann/json.hpp>
#include <stdio.h>

using json = nlohmann::json;
class Solution {
    public:
        int twoSum(int num1,int num2) {
            return num1 + num2;
        }
    };


int main(int argc,char* argv[]) {
    int num1 = std::stoi(argv[1]);
    int num2 = std::stoi(argv[2]);
    Solution solution;
    json j = solution.twoSum(num1, num2);
    std::cout << j << std::endl;
    return 0;
}