// let tab=[12,5,22,-6,0,-12];
// let min=tab[0];
// for(let i=0;i<tab.length;i++)
// {
//    if(tab[i]<min)
//     min=tab[i];
// }
let ch=" o m a";
let cpt=0;

for(let i=0;i<ch.length;i++)
    if(ch[i]!=' ')
        cpt++;
console.log(cpt);
    let ch=prompt("entre une chaine:");
    let x=prompt("entre caracter:");
    // let x=Number(prompt("entre une nomber:"));
    let trouve=0;
    let pos=0;
    for(let i=0;i<ch.length;i++){
 if(ch[i]==x){
            trouve=1;
            pos=i;
        break;
        }
    }
       if(trouve==1)
        console.log("le nombre caracter et existe dans la position "+pos);
    else 
        console.log("le caracter n'existe pas");
          