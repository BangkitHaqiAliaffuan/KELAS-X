// Online C++ compiler to run C++ program online
#include <iostream>
using namespace std;

int main() {
    int panjang, lebar;
    cout << "masukkan panjang ";
    cin >> panjang;
    cout << "masukkan lebar ";
    cin >> lebar;

    for (int i = 1;  i <= panjang; i++)
    {
        for (int j = 1; j <= lebar; j++)
        {
        cout << "*";
        }
        std::cout << endl;
    }
    return 0;
}
