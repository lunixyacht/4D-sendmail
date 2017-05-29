# 4D-SENDMAIL

Composant pour 4D

permet d'envoyer des emails en utilisant la librairie php swiftmailer


Exemple d'utilisation : 
 
 <pre><code>
 TABLEAU TEXTE($A_Errors;0)
 TABLEAU TEXTE($Array_Bcc;0)
 
 C_TEXTE($SendMessage)
 C_OBJET($Message)
 
   //---- Transport du message ----//
 OB FIXER($Message;SM_Host;"smtp.yourhost.com")
 OB FIXER($Message;SM_Port;25)  // Defaut 25
 OB FIXER($Message;SM_Username;"username")
 OB FIXER($Message;SM_Password;"userpassword")
 
   // ---- Construction du message ----/
 OB FIXER($Message;SM_From;"me@mydomain.com")
 OB FIXER($Message;SM_To;"yourdestinataire@gmail.com")
 OB FIXER($Message;SM_Subject;"Le sujet de mon super message ! ")
 OB FIXER($Message;SM_Body;"Mon super message .....")
 
 // ---- Attention toutes les constantes de swiftmailer n'on pas été ecrites dans les constantes de 4D --- A faire ou remplacer simplement les valeures de swiftmailer  // 
 // OB FIXER($Message;SM_Charset;"iso-8859-2")  // Defaut utf-8
 OB FIXER($Message;SM_MaxLineLength;1000)  //   maximum length longer than 1000 characters according to RFC 2822
 OB FIXER($Message;SM_Sender;"jf.tanguy@t-yacht.com")  // Expéditeur idem from 
 OB FIXER($Message;SM_Priority;2)  // 1->5 Highest , High , Normal , Low , Lowest
   
 // OB FIXER($Message;SM_Bcc;$Array_Bcc)  // Tableau texte Idem To
 // @FIXME ajouter pieces jointes, 
 
 Si (sm_sendmail ($Message))
    $SendMessage:=sm_getmessage 
 Sinon 
    sm_error (->$A_Errors)
 Fin de si 
 
 </code></pre>