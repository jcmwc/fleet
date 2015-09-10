
  <div class="main_resize">
    <div class="resize param_comte">
      <h1 class="bcktitle ajust_title">Rapport</h1>
      <?if(testoption("RFLO")){?>
      <form id="compterapport_form"  action="<?urlp($_GET["arbre"])?>" method="POST">
        <?if(count($tbl_list_agence)>1){?>
        <div class="rowElem">
          <label>Agence :</label>
          <select  name="agence">
            <option value="">Choisir</option>
            <?for($i=0;$i<count($tbl_list_agence);$i++){?>
              <option value="<?=$tbl_list_agence[$i]["agence_compte_id"]?>" <?=($_POST["agence"]==$tbl_list_agence[$i]["agence_compte_id"])?"selected":""?>><?=$tbl_list_agence[$i]["libelle"]?></option>
            <?}?>
          </select>
        </div>
        <?}else{?>
        <input type="hidden" name="agence" value="<?=$tbl_list_agence[0]["agence_compte_id"]?>"/>
        <?}?>
        <div class="rowElem">
          <label>Rapport :</label>
          <select  name="template">
            <option value="kilometrique" <?=($_POST["template"]=="kilometrique")?"selected":""?>>Kilométrique</option>
            <option value="compteurs" <?=($_POST["template"]=="compteurs")?"selected":""?>>Compteurs</option>
            <option value="horaire" <?=($_POST["template"]=="horaire")?"selected":""?>>Horaire</option>
            <!-- <option value="entretien" <?=($_POST["template"]=="entretien")?"selected":""?>>Entretien</option> -->
            <option value="flotte" <?=($_POST["template"]=="flotte")?"selected":""?>>Flotte journalier</option>
            <option value="flotte02" <?=($_POST["template"]=="flotte02")?"selected":""?>>Flotte hebdomadaire</option>
            <option value="flotte03" <?=($_POST["template"]=="flotte03")?"selected":""?>>Flotte mensuel</option>            
          </select>
        </div>
        <div class="content_filt_submit">
          <input class="submit_butt" type="submit" value="Valider">
        </div>
      </form>
      <?}?>
      <?if(testoption("RAPH")){?>
      <form id="rapport_vehicule_form"action="<?urlp($_GET["arbre"])?>" method="POST" <?if(testoption("RAPH")&&!testoption("RFLO")){?>style="display:block"<?}?>>
        <div class="rowElem">
          <label>Véhicule :</label>
          <select name="vehicule">
            <?for($i=0;$i<count($tbl_list_vehicule);$i++){?>
            <option value="<?=$tbl_list_vehicule[$i]["phantom_device_id"]?>" <?=($_POST["vehicule"]==$tbl_list_vehicule[$i]["phantom_device_id"])?"selected":""?>><?=$tbl_list_vehicule[$i]["nomvehicule"]?></option>
            <?}?>
          </select>
        </div>
        <div class="rowElem">
          <label>Rapport:</label>
          <select  name="template">
          <option value="vehicule" <?=($_POST["template"]=="vehicule")?"selected":""?>>Rapport journalier</option>
          <option value="hebdo" <?=($_POST["template"]=="hebdo")?"selected":""?>>Rapport hebdomadaire</option>
          <option value="mensuel" <?=($_POST["template"]=="mensuel")?"selected":""?>>Rapport Mensuel</option>
          <option value="periodique" <?=($_POST["template"]=="periodique")?"selected":""?>>Rapport de période</option>
          <!--
          <option value="detail" <?=($_POST["template"]=="detail")?"selected":""?>>Rapport détaillé</option>
          <option value="visite" <?=($_POST["template"]=="visite")?"selected":""?>>Rapport de visite </option>
          -->
          </select>
        </div>
        <div class="content_filt_submit">
          <input class="submit_butt" type="submit" value="Valider">
        </div>
      </form>
      <?}?>
      <div class="lien_veh_alarm_compterp">
        <?if(testoption("RFLO")){?>
        <div><input id="agence_compterapport_butt" type="button" class="button_butt" value="Agence"></div>
        <?}?>
        <?if(testoption("RAPH")){?>
        <div><input id="vehicule_compterapport_butt" type="button" class="button_butt" value="Vehicule"></div>
        <?}?>
        <!--
        <div><input type="button" class="button_butt" value="Alarme" onclick="window.location='<?=urlp($_GET["arbre"])?>?template=alarme'"></div>
        -->
      </div>
    </div>
  </div>