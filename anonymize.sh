#!/usr/bin/env bash
# Script pour anonymiser les snapshots XML en remplaçant les informations personnelles par des valeurs génériques.
# Usage: ./anonymize.sh [--dry-run]

DRY_RUN=false
if [ "$1" = "--dry-run" ]; then
    DRY_RUN=true
fi

# Fonction pour anonymiser un fichier pour un tableau associatif
anonymise_file() {
    local file=$1
    local table_name=$2
    # Bash 4+: référence à un tableau associatif
    declare -n tags="$table_name"

    for tag in "${!tags[@]}"; do
        local value="${tags[$tag]}"
        if [ "$DRY_RUN" = true ]; then
            perl -CS -pe "s|<$tag>[^<]*</$tag>|<$tag>$value</$tag>|g" "$file"
        else
            perl -CS -i -pe "s|<$tag>[^<]*</$tag>|<$tag>$value</$tag>|g" "$file"
        fi
    done
}

# Déclaration correcte des tableaux associatifs
declare -A tags_xml_chp_renc=( ["xja"]="DUPONT Michel" ["xjb"]="DUPOND Micheline" ["ja"]="DUPONT Michel" ["jb"]="DUPOND Micheline" )
declare -A tags_nom_prenom=( ["nom"]="DUPONT" ["prenom"]="Michel" )
declare -A tags_xml_partie=( ["nom"]="DUPONT Michel" )
declare -A tags_xml_partie_mysql=( ["advnompre"]="DUPONT Michel" )
declare -A tags_xml_club_detail=( ["nomcor"]="DUPONT" ["prenomcor"]="Michel" ["mailcor"]="michel@dupont.com" ["telcor"]="0123456789" )
declare -A tags_xml_res_cla=( ["nom"]="DUPONT Michel" )
declare -A tags_xml_result_indiv_classement=( ["nom"]="DUPONT" )
declare -A tags_xml_result_indiv_parties=( ["vain"]="DUPONT Michel" ["perd"]="DUPOND Micheline" )

# Parcours des fichiers
for file in ./docs/snapshots/xml_chp_renc/*.xml; do
    echo "Anonymising $file ..."
    anonymise_file "$file" tags_xml_chp_renc
done

for pattern in ./docs/snapshots/xml_joueur/*.xml ./docs/snapshots/xml_licence/*.xml ./docs/snapshots/xml_licence_b/*.xml ./docs/snapshots/xml_liste_joueur/*.xml ./docs/snapshots/xml_liste_joueur_o/*.xml; do
    echo "Anonymising $pattern ..."
    anonymise_file "$pattern" tags_nom_prenom
done

for file in ./docs/snapshots/xml_partie/*.xml; do
    echo "Anonymising $file ..."
    anonymise_file "$file" tags_xml_partie
done

for file in ./docs/snapshots/xml_partie_mysql/*.xml; do
    echo "Anonymising $file ..."
    anonymise_file "$file" tags_xml_partie_mysql
done

for file in ./docs/snapshots/xml_club_detail/*.xml; do
    echo "Anonymising $file ..."
    anonymise_file "$file" tags_xml_club_detail
done

for file in ./docs/snapshots/xml_res_cla/*.xml; do
    echo "Anonymising $file ..."
    anonymise_file "$file" tags_xml_res_cla
done

anonymise_file "./docs/snapshots/xml_result_indiv/classement.xml" tags_xml_result_indiv_classement
anonymise_file "./docs/snapshots/xml_result_indiv/parties.xml" tags_xml_result_indiv_parties
