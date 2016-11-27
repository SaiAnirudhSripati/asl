
#Name:Sai Anirudh Sripati
#Student ID:10382761

#Instructions:Please make sure the "wordlist.txt" file is present before running the program.
begin
wordList=[];
wordLength=0;
wordSplit=[];
IO.foreach('wordlist.txt') do |line|
  wordList.push(line);
end
word=wordList.sample.gsub(/\s+/, "").downcase;#array.sample to fetch random word.
wordLength=word.length;
wordSplit=word.split("");

if wordList.length >=1
  puts "Word contains #{wordLength} letters.";
  puts "You have #{wordLength+1} attempts left.";
  tempList=[]
  tempWord="";
  attempts=wordLength;
  for i in 0..wordLength.to_i-1
    tempList.push('_');
  end
  
  for i in 0..tempList.length-1
    tempWord=tempWord+" "+tempList[i].to_s;
  end
  puts tempWord;
  indexes_scanned=[];
  found=false;
 
  for i in 0..tempList.length
    puts "Enter word to solve,or letter to reveal: ";
    user_input=gets.gsub(/\s+/, "").downcase;
    if user_input.length>1
      #User entered word
      if user_input.eql? word
        found=true;
        tempWord=word;
        break;
      else
        if attempts>0
          puts "You have #{attempts} attempts left";

        end

      end
    else
	
      if attempts>0
        puts "You have #{attempts} attempts left";
        #User entered letter
        tempIndex=0;
        for i in 0..wordLength-1
          if user_input.to_s.eql? wordSplit[i].to_s
            if !(indexes_scanned.include? i)
              found=true;
              tempindex=i;
              indexes_scanned.push(i);
              tempList[i]=user_input;
              attempts=attempts-1;
              break;
            end
          end
        end
		else
			tempIndex=0;
			for i in 0..wordLength-1
				if user_input.to_s.eql? wordSplit[i].to_s
					if !(indexes_scanned.include? i)
						found=true;
						tempindex=i;
						indexes_scanned.push(i);
						tempList[i]=user_input;
						break;
            end
          end
        end
      end
    end
    if found
      tempWord="";
      for i in 0..tempList.length-1
        tempWord=tempWord+" "+tempList[i].to_s;
       end
	   found=false;
       
      
	   puts tempWord;
    else
      attempts=attempts-1;
      puts tempWord;
    end
    if tempWord.to_s.gsub(/\s+/, "").eql? word
      break;
    end
	
 end



  if tempWord.to_s.gsub(/\s+/, "").eql? word
    puts"Congratulations you guessed it right.";
  else
    puts "You lost the game please try again.";
  end



else
  puts "No words found.";
end
rescue Exception => msg  
	print "An IO error has occurred,Please make sure the wordlist.txt file is present in the current directory."
end