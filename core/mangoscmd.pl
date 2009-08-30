#!/usr/bin/perl

use Net::Telnet ();

$rurl;
%hfields =();
%input="";
$result="";
$resultmsg="";

sub urldecode{    #очень полезная функция декодирования
 local($val)=@_;  #запроса,будет почти в каждой вашей CGI-программе
 $val=~s/\+/ /g;
 $val=~s/%([0-9A-H]{2})/pack('C',hex($1))/ge;
 return $val;
}

sub get_parameters {
  local (*in) = shift;
  local ($i, $key, $val);
  
  if ($ENV{'REQUEST_METHOD'} eq 'GET'){
    $in = $ENV{'QUERY_STRING'};
  } else {
    read(STDIN, $in, $ENV{'CONTENT_LENGTH'});
  }
  $in = urldecode($in);
  
  @in = split(/[&;]/,$in);

  foreach $i (0 .. $#in) {
    $in[$i] =~ s/\+/ /g;
    ($key, $val) = split(/=/,$in[$i],2);
    $key =~ s/%(..)/pack("c",hex($1))/ge;
    $val =~ s/%(..)/pack("c",hex($1))/ge;

    $val =~ s/(<P>\s*)+/<p>/ig;
    $val =~ s/</&lt/g;
    $val =~ s/>/&gt/g;
    $val =~ s/&ltb&gt/<b>/ig;
    $val =~ s!&lt/b&gt!</b>!ig;
    $val =~ s/&lti&gt/<b>/ig;
    $val =~ s!&lt/i&gt!</b>!ig;
    $val =~ s!\cM!!g;
    $val =~ s!\n\n!<p>!g;
    $val =~ s!\n! !g;

    $in{$key} .= "\0" if (defined($in{$key}));
    $in{$key} .= $val;
  }
  return scalar(@in);
}

sub myredirect {
  local ($outstr, $hf);
  
  $hf = "";
  foreach $key (keys %hfields) { 
    $hf .= "iForm.appendChild(CreateHidden('$key', '$hfields{$key}'));\n";
  }
  
  $outstr = "
  <html><body>
    <script language='javascript' type='text/javascript'>
      function CreateHidden(id, value) {
        var oHidden = document.createElement('input');
        oHidden.type='hidden';
        oHidden.id=id;
        oHidden.name=id;  
        oHidden.value = value;
        return oHidden;
      }
      
      function Redirect() {
        try {
            var iForm = document.createElement('form');

            iForm.action = '$rurl';
            iForm.method = 'post';

            $hf
            
            document.body.appendChild(iForm);
            iForm.submit();
        }
        catch (e) {
            alert('Ошибка при работе.');
        }
      }

      window.setTimeout('Redirect()', 0);
      
    </script>
  </body></html>";
  
  print $outstr;
}

sub myresponse {
  $hfields{"result"}=$result;
  $hfields{"resultmsg"}=$resultmsg;
  
  $hfields{"action"} = $action;
  $hfields{"type"} = $type;
  $hfields{"typeval"} = $typeval;
  $hfields{"reason"} = $reason;
  $hfields{"bantime"} = $bantime;

  $hfields{"address"} = $address;
  $hfields{"raport"} = $raport;
  $hfields{"myuser"} = $myuser;
  $hfields{"mypass"} = $mypass;
  
  myredirect();
  exit;
}

sub errhandler {
  local($val)=@_;
  $result="Error";
  $resultmsg=$val;
  myresponse;
  exit;
}

sub sendcmd {
  local($t) = new Net::Telnet (Host=>$address,
                        Port=>$raport,
                        Binmode=>0,
                        Prompt=>'m/mangos>/',
                        Errmode => "return"
  );                  
  $t->open() or die errhandler ('NotConnect');
  $t->waitfor(String=>'Wellcome to WOW Server v3.1.3. Massacre.Net.');
  $t->print('USER '.$myuser);
  sleep(1);
  $t->print('PASS '.$mypass);
  sleep(1);
  $t->waitfor(String=>'+Logged in.') or die errhandler ('WrongUserOrPass');
  $t->waitfor(Match=>'m/mangos>/') or die errhandler ('NotResponse');
  @line = $t->cmd(String=>$cmd) or die errhandler ('NotResponse');
  $t->close();
  
  for $element (@line) {
    $resultmsg .= $element."<br />\n";
  }
  $resultmsg =~ s!\n! !g;
  $result="OK";
}

sub printargs {
  print "rurl is: $rurl<br>\n";
  print "action is: $action<BR>\n";
  print "type is: $type<BR>\n";
  print "typeval is: $typeval<BR>\n";  
  print "reason is: $reason<BR>\n";
  print "bantime is: $bantime<BR>\n";
  print "address is: $address<BR>\n";
  print "raport is: $raport<BR>\n";  
  print "myuser is: $myuser<BR>\n";
  print "mypass is: $mypass<BR>\n";  
}

print "Content-Type: text/html\n\n";

get_parameters(*input);
$rurl = $input{'rurl'};
$rurl =~ s!_and_!&!ig;
$action = $input{'action'};

$type = $input{'type'};
$typeval = $input{'typeval'};
$reason = $input{'reason'};
$bantime = $input{'bantime'};

$address = $input{'address'};
$raport = $input{'raport'};
$myuser = $input{'myuser'};
$mypass = $input{'mypass'};

$cmd='';
if ($action eq 'ban'){
    $cmd = 'ban '.$type.' '.$typeval.' '.$bantime.' "'.$reason.'"';
} elsif ($action eq 'unban') {
    $cmd = 'unban '.$type.' '.$typeval;
}

sendcmd;
myresponse;

