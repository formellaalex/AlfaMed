#include <stdio.h>

void zeruj(int x[n][n],int kolumna, int n){

	int i;
	for(i=0;i<n;i++){
		x[kolumna][i] = 0;
	}
}
int main(){

	int kolumna;
	scanf("%d", &kolumna);
	if(kolumna > n){
		printf("Nie ma takiej kolumny\n");
	}
	return 0;
}
