function nbOcc(s,ss){
    if( typeof s =='string' && typeof ss=='string'){
        var Occ=0;
        while(true){
            var d= s.search(ss);
            //search il recherche un string dans une chaine de caractere et s'il trouve il renvoi la chaine sinon il renvoi -1
            if( d != -1){
                ++Occ;
                s=s.substring(d+1);
            }else break;
        }
        return Occ;
        
    }else{
        return NaN;
    }
}