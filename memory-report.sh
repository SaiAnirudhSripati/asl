#Advanced Scripting Languages
#Workshop 2
#Name:Sai Anirudh 
#ID:10382761

echo '-------------------------System Report---------------------------------';

echo -e 'Date:' $(date +%d)'/'$(date +%m)'/'$(date +%Y)'\tTime: ' $(date +%T) '\tSystem Name: '$(hostname);
echo '-----------------------------------------------------------------------';
echo 'Uptime:'$(uptime |grep -ohe 'up.*[0-9]\?[0-9]\?[ ]\?[days,]\?[ ]\?[0-9]\?[0-9][:][0-9]\?[0-9]'|sed 's/up//g'|sed 's/:/ hours, /g')' minutes';
users='Current Users: '$(who --count|grep -ohe '[# users=][0-9]'|sed 's/=//g')
cpuLoad='Cpu Load: '$(uptime|grep -ohe 'load average[s: ].*'|sed 's/load average[s:] //g'|awk '{print $1}'|sed 's/,//g');
memory='Memory usage: '$(free -m|awk 'NR==2{printf "%s/%s MB (%.2f%%)\n", $3,$2,$3*100/$2 } ')
disk='Disk usage: '$(df -h|awk 'NR==4{printf "%s/%sB (%.2f%%)", $3,$2,$3*100/$2}' );
echo -e $memory'\t'$disk
echo -e $users'\t\t'$cpuLoad'\n'


echo '----------------------------end report---------------------------------';
