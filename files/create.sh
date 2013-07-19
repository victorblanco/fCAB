#!/bin/bash
cd $1
tar xzvf  $1/app/core/files/struct.tar.gz 
chmod -R 777 $1/app/propias/templates/PRES
chmod -R 777 $1/app/propias/controls/templates/PRES
chmod -R 777 $1/archivos
