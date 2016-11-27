#Sai Anirudh Sripati
#10382761

while read  unit_code 
do
year=$1

sqlite3 ecu_units.db "create table if not exists unit_activities_table(unit_code varchar ,title varchar,act_id int Primary Key,semester varchar,location varchar,day varchar,a_time varchar,room varchar,alloc_places varchar,comments varchar)";
activities=$(curl -d "p_unit_cd="$unit_code"&cndSubmit=Search&p_ci_year="$year http://apps.wcms.ecu.edu.au/semester-timetable/lookup |grep -ohe '<a .*>Activities</a>'|sed 's/">Activities<\/a>//g;s/<a href="//g')

function insert_row () {

title=$title;
semester=$semester;
location="";
act_id=$1;
day=$2;
a_time=$3;
room=$4;
if [[ $room == *"JO"* ]]
then
location="Joondalup"
elif [[ $room == *"ML"* ]]
then
location="Mount Lawely"
elif [[ $room == *"BU"* ]]
then
location="Bunbury"
else
location="N/A"
fi
alloc_places=$5;
comments=$6;



sqlite3 ecu_units.db "Insert into unit_activities_table(unit_code,title,act_id,location,semester,day,a_time,room,alloc_places,comments) values('$unit_code','$title','$act_id','$location','$semester','$day','$a_time','$room','$alloc_places','$comments');"


}

OIFS=$IFS;
IFS=',';

unit_head=$(curl $activities|grep -ohe '<p><a name="top"></a><strong>'$unit_code'.*</p>'|sed 's/<p>//g;s/<\/p>//g;s/<strong>//g;s/<\/strong>//g;s/<a name="top">//g;s/<\/a>/,/g;s/<\/font>/,/g;s/<font color="red">//g;s/<\/a>/,/g;s/(//g;s/)//g;s/&nbsp;//g');
semester=$(echo -e $unit_head|grep -ohe ' [0-9][0-9][0-9][0-9].*'|sed 's/^[ ] //g');
title=$(echo -e  $unit_head|sed 's/'$semester'//g;s/'$unit_code'//g;s/^[ ] //g');
var=($(curl  $activities|grep -ohe '<td.*'|sed 's/<td .*\?[ ]\?[ ]>//g'|sed -e 's/<[^>]*>//g'|sed 's/Group -->//g'|sed 's/&nbsp;/break;/g'|awk {'print $0"," '} ));


j=1;

col_values=();
for i in  ${var[@]}
 do 

   if [[ $(echo $i|sed 's/[:space:]+//g') > 1 ]] 
   then      
     col_values[$j]=$(echo $i|sed 's/^[ \t]*//g;s/[ \t]*$//g'|tr --delete '\n');
      
	if [[ ${col_values[$j]} == *"break;"* ]] 
      then
        col_values[$j]=" ";
        insert_row ${col_values[1]} ${col_values[2]} ${col_values[3]} ${col_values[4]} ${col_values[5]} ${col_values[6]};
        let 'j=1';
      else
       	j=$((j+1));
      fi	
fi
done
done

sqlite3 ecu_units.db -column -header "select * from unit_activities_table;"


