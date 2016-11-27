#Advanced Scripting Languages
#Workshop 1
#Name:Sai Anirudh 
#ID:10382761
read message_body;
echo ${message_body} | mail -s $2 $1;
