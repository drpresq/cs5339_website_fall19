#!/bin/bash

USER=gwwood || evazquezgalarza
mysqlsh -u $USER -h cssrvlab01.utep.edu -D "${USER}_f19_db" -f carparts.sql --password=*utep2020!
#mysqlsh -u $USER -h cssrvlab01.utep.edu -D "${USER}_f19_db" -f database_definition.sql --password=*utep2020!
#mysqlsh -u $USER -h cssrvlab01.utep.edu -D "${USER}_f19_db" -f stored_procedures.sql --password=*utep2020!