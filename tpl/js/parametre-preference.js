function validerPref(){
      var delaisName = document.formPref.delaimail.value;
      var dureeNamesec = document.formPref.dureeminattente.value;
      var dureeNameatt = document.formPref.dureemintraj.value;


  if(delaisName == "")
  {
    alert("Ce champs est obligatoire");
    (document.formPref.delaimail.style.backgroundColor = "red");
    return false;
  }
    if(dureeNamesec == "")
  {
    alert("La durée minimum d'un trajet (s) est obligatoire");
    (document.formPref.dureeminattente.style.backgroundColor = "red");
    return false;
  }
      if(dureeNameatt == "")
  {
    alert("La durée minimum d'une attente (s) est obligatoire");
    (document.formPref.dureemintraj.style.backgroundColor = "red");
    return false;
  }

  else{
    (document.formPref.delaimail.style.backgroundColor = "green");
    (document.formPref.dureemintraj.style.backgroundColor = "green");
    (document.formPref.dureeminattente.style.backgroundColor = "green");
  }
}
