<?php
//------------------------------------------------------------------------------             
//*** French (fr)
//------------------------------------------------------------------------------
function setLanguage(){ 
    
	$lang['all_available'] = "Tous disponibles";
	$lang['partially_booked'] = "Partiellement r�serv�";
	$lang['not_avaliable'] = "Non disponible / Enti�rement r�serv�";
	$lang['legend'] = "L�gende";
	$lang['rooms'] = "chambres";
	$lang['with_reserved'] = "avec r�serv�s";
	$lang['without_reserved'] = "sans r�serv�s";
	$lang['bookings'] = "r�servations";
	$lang['all_rooms'] = "Toutes les chambres";
	$lang['reserved_and_completed'] = "R�serv�s & Termin�";
	$lang['completed_only'] = "Termin� Seul";
	
	$lang['actions'] = "Actes";
	$lang['add_category'] = "Ajouter une cat�gorie";	
	$lang['add_event'] = "Ajouter un �v�nement";    
	$lang['add_new_category'] = "Ajouter une cat�gorie Nouveau";
	$lang['add_new_event'] = "Ajouter un nouvel �v�nement";
	$lang['back'] = "Dos";
	$lang['cancel'] = "Annuler";	
	$lang['category_color'] = "Cat�gorie Couleur";	
	$lang['category_description'] = "Description de la cat�gorie";
	$lang['category_details'] = "Cat�gorie D�tails";
	$lang['category_name'] = "Nom de la cat�gorie";
	$lang['categories'] = "Cat�gories";
	$lang['categories_events'] = "Cat�gories Ev�nements";
	$lang['click_to_delete'] = "Cliquez pour effacer";
	$lang['chart_bar'] = "Histogramme";
	$lang['chart_column'] = "Graphique � barres";
	$lang['chart_pie'] = "Diagramme";
	$lang['click_view_week'] = "Cliquez pour voir cette semaine";	
	$lang['click_to_print'] = "Cliquez ici pour imprimer";	
	$lang['close'] = "Fermer";
	$lang['close_lc'] = "fermer";
	$lang['collapse'] = "effondrement";	
	$lang['debug_info'] = "Debug Info";	
	$lang['default'] = "par d�faut";
	$lang['details'] = "D�tails";
	$lang['delete'] = "Effacer";
	$lang['delete_events'] = "Supprimer Ev�nements";
	$lang['delete_by_range'] = "Supprimer selon la fourchette de";
	$lang['duration'] = "Dur�e";	
	$lang['edit'] = "�diter";
	$lang['edit_category'] = "Modifier la cat�gorie";	
	$lang['edit_event'] = "Modifier un �v�nement";	
	$lang['events_categories'] = "Cat�gories Ev�nements";
	$lang['event_name'] = "Nom de l'�v�nement";
	$lang['event_date'] = "Date de l'�v�nement";
	$lang['event_time'] = "Heure de l'�v�nement";	
	$lang['event_description'] = "Description de l'�v�nement";
	$lang['event_details'] = "D�tails de l'�v�nement";
	$lang['events'] = "�v�nements";
	$lang['events_management'] = "Gestion d'�v�nements";
	$lang['events_statistics'] = "Statistiques �v�nements";
	$lang['expand'] = "D�velopper";	
	$lang['from'] = "� partir de";
	$lang['go'] = "Aller";
	$lang['hours'] = "Heures d'ouverture";
	$lang['manage_events'] = "G�rer les �v�nements";	
	$lang['not_defined'] = "pas d�fini";
	$lang['occurrences'] = "�v�nements";	
	$lang['one_time'] = "Une seule fois";
	$lang['or'] = "ou";
	$lang['order_lc'] = "ordre";
	$lang['orders_lc'] = "ordres";
	$lang['pages'] = "Pages";	
	$lang['print'] = "Imprimer";
	$lang['repeat_every'] = "R�p�ter chaque";
	$lang['repeatedly'] = "� plusieurs reprises";
	$lang['select'] = "s�lectionner";	
	$lang['select_event'] = "�v�nement select";
	$lang['show_all'] = "Afficher toutes les";	
	$lang['select_category'] = "S�lectionner une cat�gorie";
	$lang['select_chart_type'] = "S�lectionnez le type de graphique";
	$lang['start_time'] = "Heure de d�but";
	$lang['statistics'] = "Statistiques";
	$lang['th'] = "�me"; // suffix for dates, like: 25th
	$lang['to'] = "�";	
	$lang['today'] = "Aujourd'hui";
	$lang['top_10_events'] = "Top 10 des �v�nements";	
	$lang['total_categories'] = "Total des cat�gories";
	$lang['total_events'] = "Total des �v�nements";	
	$lang['total_running_time'] = "Dur�e totale";
	$lang['undefined'] = "Ind�fini";
	$lang['update'] = "Mettre � jour";
	$lang['update_category'] = "Mise � jour Cat�gorie";
	$lang['update_event'] = "Mise � jour de l'�v�nement";
	$lang['view'] = "Vue";
	$lang['view_events'] = "Afficher les �v�nements";
	
	$lang['lbl_add_event_to_list'] = "Il suffit d'ajouter � la liste des �v�nements";
	$lang['lbl_add_event_occurrences'] = "Ajouter les occurrences de cet �v�nement";

	$lang['msg_editing_event_in_past'] = "L'�v�nement ne peut �tre ajout�e dans le temps pass�! S'il vous pla�t entrer de nouveau.";
	$lang['msg_this_operation_blocked'] = "Cette op�ration est bloqu�e!";
	$lang['msg_this_operation_blocked_demo'] = "Cette op�ration est bloqu�e dans la version DEMO!";
	$lang['msg_timezone_invalid'] = "Fuseau horaire ID '_TIME_ZONE_' n'est pas valide.";
	$lang['msg_view_type_invalid'] = "Default View '_DEFAULT_VIEW_' �tait pas permis! S'il vous pla�t s�lectionner un autre.";

    $lang['error_inserting_new_events'] = "Une erreur s'est produite lors de l'insertion de nouveaux �v�nements! S'il vous pla�t r�essayer plus tard.";
	$lang['error_inserting_new_category'] = "Une erreur s'est produite lors de l'insertion nouvelle cat�gorie! S'il vous pla�t r�essayer plus tard.";
    $lang['error_deleting_event'] = "Une erreur s'est produite lors de la suppression �v�nement! S'il vous pla�t r�essayer plus tard.";
	$lang['error_duplicate_event_inserting'] = "L'�v�nement avec un tel nom a d�j� �t� ajout�e � la p�riode s�lectionn�e! S'il vous pla�t choisir une autre.";
	$lang['error_duplicate_events_inserting'] = "P�riode s�lectionn�e est d�j� occup�e! S'il vous pla�t choisir une autre.";
    $lang['error_updating_event'] = "Une erreur s'est produite pendant l'actualisation �v�nement! S'il vous pla�t r�essayer plus tard.";
	$lang['error_category_exists'] = "Cat�gorie avec un tel nom existe d�j�! S'il vous pla�t choisir un autre nom.";
	$lang['error_event_exists'] = "L'�v�nement avec un tel nom existe d�j�! S'il vous pla�t choisir un autre nom.";
	$lang['error_from_to_hour'] = "'De:' heures ne peut �tre sup�rieure � 'To' heures! S'il vous pla�t entrer de nouveau.";
    $lang['error_updating_category'] = "Une erreur s'est produite pendant l'actualisation cat�gorie! S'il vous pla�t r�essayer plus tard.";
	$lang['error_deleting_category'] = "Une erreur s'est produite lors de la suppression cat�gorie! S'il vous pla�t r�essayer plus tard.";
	$lang['error_deleting_event_hours'] = "Impossible de supprimer le cas! Moins de _HOURS_ heure rest�.";	
	$lang['error_deleting_event_past'] = "Impossible de supprimer le cas dans le pass�!";
	$lang['error_no_event_found'] = "Aucune manifestation trouv�e!";
	$lang['error_no_dates_found'] = "Pas de dates appropri�es ont �t� trouv�es � l'�v�nement ins�rer! S'il vous pla�t entrer de nouveau.";

    $lang['success_new_event_was_added'] = "Un nouvel �v�nement a �t� ajout� avec succ�s!";
    $lang['success_event_was_deleted'] = "Event '_EVENT_NAME_' a �t� supprim� avec succ�s!";
	$lang['success_events_were_deleted'] = "Occurrences des �v�nements pour la p�riode de temps s�lectionn�e ont �t� supprim� avec succ�s!";
    $lang['success_event_was_updated'] = "L'�v�nement a �t� mis � jour!";
	$lang['success_new_category_added'] = "Nouvelle cat�gorie a �t� ajout� avec succ�s!";
	$lang['success_category_was_updated'] = "Cat�gorie a �t� mis � jour!";
    $lang['success_category_was_deleted'] = "Cat�gorie a �t� supprim� avec succ�s!";
    

    // date-time
    $lang['day']    = "jour";
    $lang['month']  = "mois";
    $lang['year']   = "ann�e";
    $lang['hour']   = "heure";
    $lang['min']    = "min";
    $lang['sec']    = "sec";
    
    $lang['daily']     = "Quotidien";
    $lang['weekly']    = "Hebdomadaire";
    $lang['monthly']   = "Mensuel";
    $lang['yearly']    = "Annuel";
	$lang['list_view'] = "Voir la liste";

    $lang['sun'] = "Dim";
	$lang['mon'] = "Lun";
	$lang['tue'] = "Mar";
	$lang['wed'] = "Mer";
	$lang['thu'] = "Jeu";
	$lang['fri'] = "Ven";
	$lang['sat'] = "Sam";    

    $lang['sunday'] = "Dimanche";
	$lang['monday'] = "Lundi";
	$lang['tuesday'] = "Mardi";
	$lang['wednesday'] = "Mercredi";
	$lang['thursday'] = "Jeudi";
	$lang['friday'] = "Vendredi";
	$lang['saturday'] = "Samedi";
    
    $lang['months'][1] = "Janvier";
    $lang['months'][2] = "F�vrier";
    $lang['months'][3] = "Mars";
    $lang['months'][4] = "Avril";
    $lang['months'][5] = "Mai";
    $lang['months'][6] = "Juin";
    $lang['months'][7] = "Juillet";
    $lang['months'][8] = "Auguste";
    $lang['months'][9] = "Septembre";	
    $lang['months'][10] = "Octobre";
    $lang['months'][11] = "Novembre";
    $lang['months'][12] = "D�cembre";
    
    return $lang;
}
?>