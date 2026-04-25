// let n = 5;

// for (let i = 0; i < n; i++) {
//     let l = "";
//     for (let j = 0; j <= i; j++) {
//         l += "* ";
//     }
//     console.log(l);
// }
// let n = 5;

// for (let i = 0; i <= n; i++) {
//     let l = "";
//     for (let j = n-i ; j > 0; j--) {
//         l += "* ";
//     }
//     console.log(l);
// }
// function triangle(n)
// {
//     for (let i = 0; i <= n; i++) {
//     let l = "";p
//     for (let j = n-i ; j > 0; j--) {
//         l += "* ";
//     }
//     console.log(l);
// }
// }
// triangle(5);
// let utilisateur={nom:"oumaima",age:24,ville:"safi",note:[1,22,4,5,75]};
// console.log("nom est:"+ utilisateur.nom +" age est:"+ utilisateur.age +" ville est:"+ utilisateur.ville);
// for(let i=0;i<utilisateur.note.length;i++)
// {
//     if(utilisateur.note[i]%2==0)
//     console.log(utilisateur.note[i]);
// }

// let tab=["oumaima1","safi","eddahani2","mama"];

// for(let i=0;i<tab.length;i++)
// {
//     let mot=tab[i];
//     let test=0;
//     for(j=0;j<mot.length;j++)
//     {
//         if(mot[j]>='0'&& mot[j]<='9'){
//         test=1;
//         break;
//         }
//     }
//     if(test==0)
//     {
//         console.log(mot);
//     }
// }
// let nums = [1, 2, 3, 4, 5, 6];
// for(let i=0;i<nums.length;i++)
// {
//     if(nums[i]%2==0)
//     console.log(nums[i]);
// }
// let users = [
//   {name: "Ali", age: 20},
//   {name: "Sara", age: 25},
//   {name: "Yassine", age: 17}
// ];
// let tab=[];
// for(i=0;i<users.length;i++)
// {
//   tab= users[i].name;
//   console.log(tab);
// }
// let produits = [
//   {id: 1, nom: "PC"},
//   {id: 2, nom: "Téléphone"},
//   {id: 3, nom: "Tablette"}
// ];
// for(let i=0;i<produits.length;i++)
// {
//     if(produits[i].id==2)
//     console.log(produits[i]);
// }
let lettres = ["a", "b", "a", "c", "b", "a"];

for(i=0;i<lettres.length;i++)
{
    let fois=0;
    for(let j=0;j<lettres.length;j++)
    if(lettres[i]==lettres[j])
    fois++;
    console.log(lettres[i]+fois+"fois")
}




















