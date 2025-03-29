import com.fasterxml.jackson.core.JsonProcessingException;
                                  import com.fasterxml.jackson.databind.ObjectMapper;
class Hello {
    public static void main(String[] args) throws JsonProcessingException{
      int a = 5;
      int b = 2;System.out.print(new ObjectMapper().writeValueAsString(Test.addTwoNum(a,b)));}
}class Test{
            public static int addTwoNum(int a,int b){
                return a+b;
            }
        }
