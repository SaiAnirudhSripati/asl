
#Name:Sai Anirudh Sripati
#Student ID:10382761

#Instructions:Please make sure the "wordlist.txt" file is present before running the program.
import random

try:
    wordFile=open("wordlist.txt","r");
except IOError:
    print "wordlist.txt file not found,Please create a file with words and run the program again.";
     
try:
    wordList=wordFile.readlines();
    word=random.choice(wordList);
    #print word;
    word=word.strip().lower();
    wordLength=len(word);
    splitWord=list(word);
    if len(wordList)>=1:
        print "Word contains "+str(wordLength)+" letters.";
        print "You have "+str(wordLength+1)+" attempts left.";
        tempList=[]
        tempWord="";
        attempts=wordLength;
        for i in range(wordLength):
            tempList.append("_");
        for i in range(len(tempList)):
            tempWord=tempWord+" "+str(tempList[i]);
        print tempWord;
        indexes_scanned=[];
        found=False;
        attempts=attempts;
        for i in range(len(tempList)+1):
            user_input=raw_input("Enter word to solve,or letter to reveal: ");
            user_input=str(user_input).lower();
    
            if len(user_input)>1:
                #User entered word
                if user_input==word:
                    #print "Congratulations you gussed the word correct";
                    found==True;
                    tempWord=word;
                    break;
                else:
                    if(attempts>0):
                        print "You have "+str(attempts)+" attempts left";  
        
            else:
                if(attempts>0):
                    print "You have "+str(attempts)+" attempts left";   
            #User entered letter
                tempIndex=0;
                for i in range(wordLength):
                    if user_input in splitWord[i]:
                      #  print "In word";
                        if i not in indexes_scanned:
                            #print "Not in indexes";
                            found=True;
                            tempindex=i;
                            indexes_scanned.append(i);
                            tempList[i]=user_input;
                            attempts=attempts-1;
                            break;
            if found:
                tempWord="";
                for i in range(len(tempList)):
            
                    tempWord=tempWord+" "+str(tempList[i]);
                found=False;
                print tempWord;
        
            else:
                attempts=attempts-1;
                print tempWord;
            if str(tempWord.replace(" ",""))==word:
                break;
    
        if str(tempWord.replace(" ",""))==word:
            print "Congratulations you guessed it right."
        else:
            print "You lost the game please try again."
    else:
        print "No words found."
except Exception:
    print "An IO error has occured,Please try again."

