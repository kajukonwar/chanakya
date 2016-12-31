
        var date= new Date();
        var dd = date.getDate();
        var mm = date.getMonth()+1; //January is 0!
        var yyyy = date.getFullYear();
          
        if(dd<10) 
        {
            dd='0'+dd
        } 
  
        if(mm<10) 
        {
            mm='0'+mm
         
        } 
//this array stores the available slots
var slots=new Array();

//we plan to start the slots from index 1
  slots[0]="slots";
//the slot timings has a sequence after every 3 hours
  var h=0;
  var i=1;
//total of 80 slots
  while(i<81)
  {

    h1=h+1;
    h2=h+2;
    h3=h+3;

    slots[i]=new Array();

    ad1_start = mm+'/'+dd+'/'+yyyy+' '+h+':16:46';
    
                 
  ad1_end= mm+'/'+dd+'/'+yyyy+' '+h+':17:03';

  var ad1_start_time=Math.round(new Date(ad1_start).getTime() / 1000);
  
  var ad1_end_time=Math.round(new Date(ad1_end).getTime() / 1000);

  slots[i][0]=ad1_start_time;
  slots[i][1]=ad1_end_time;
   
   i++;

  slots[i]=new Array();

  ad2_start = mm+'/'+dd+'/'+yyyy+' '+h+':34:00';
                   
  ad2_end= mm+'/'+dd+'/'+yyyy+' '+h+':34:17';

  var ad2_start_time=Math.round(new Date(ad2_start).getTime() / 1000);

  var ad2_end_time=Math.round(new Date(ad2_end).getTime() / 1000);

  slots[i][0]=ad2_start_time;
  slots[i][1]=ad2_end_time;
   i++;



  slots[i]=new Array();
  ad3_start = mm+'/'+dd+'/'+yyyy+' '+h+':51:18';
                   
  ad3_end= mm+'/'+dd+'/'+yyyy+' '+h+':51:35';

  var ad3_start_time=Math.round(new Date(ad3_start).getTime() / 1000);

  var ad3_end_time=Math.round(new Date(ad3_end).getTime() / 1000);
  slots[i][0]=ad3_start_time;
  slots[i][1]=ad3_end_time;
   i++;

   slots[i]=new Array();

  ad4_start = mm+'/'+dd+'/'+yyyy+' '+h1+':09:41';
                   
  ad4_end= mm+'/'+dd+'/'+yyyy+' '+h1+':09:58';

  var ad4_start_time=Math.round(new Date(ad4_start).getTime() / 1000);

  var ad4_end_time=Math.round(new Date(ad4_end).getTime() / 1000);
  slots[i][0]=ad4_start_time;
  slots[i][1]=ad4_end_time;
   i++;


   slots[i]=new Array();

  ad5_start = mm+'/'+dd+'/'+yyyy+' '+h1+':26:54';
                   
  ad5_end= mm+'/'+dd+'/'+yyyy+' '+h1+':27:11';

  var ad5_start_time=Math.round(new Date(ad5_start).getTime() / 1000);

  var ad5_end_time=Math.round(new Date(ad5_end).getTime() / 1000);
  slots[i][0]=ad5_start_time;
  slots[i][1]=ad5_end_time;
   i++;


  slots[i]=new Array();
  ad6_start = mm+'/'+dd+'/'+yyyy+' '+h1+':43:51';
                   
  ad6_end= mm+'/'+dd+'/'+yyyy+' '+h1+':44:08';

  var ad6_start_time=Math.round(new Date(ad6_start).getTime() / 1000);

  var ad6_end_time=Math.round(new Date(ad6_end).getTime() / 1000);
  slots[i][0]=ad6_start_time;
  slots[i][1]=ad6_end_time;
   i++;

  slots[i]=new Array(); 

  ad7_start = mm+'/'+dd+'/'+yyyy+' '+h2+':01:11';
                   
  ad7_end= mm+'/'+dd+'/'+yyyy+' '+h2+':01:28';

  var ad7_start_time=Math.round(new Date(ad7_start).getTime() / 1000);

  var ad7_end_time=Math.round(new Date(ad7_end).getTime() / 1000);


  slots[i][0]=ad7_start_time;
  slots[i][1]=ad7_end_time;
   i++;


   slots[i]=new Array(); 

  ad8_start = mm+'/'+dd+'/'+yyyy+' '+h2+':20:20';
                   
  ad8_end= mm+'/'+dd+'/'+yyyy+' '+h2+':20:37';

  var ad8_start_time=Math.round(new Date(ad8_start).getTime() / 1000);

  var ad8_end_time=Math.round(new Date(ad8_end).getTime() / 1000);
  slots[i][0]=ad8_start_time;
  slots[i][1]=ad8_end_time;
   i++;

  slots[i]=new Array(); 

  ad9_start = mm+'/'+dd+'/'+yyyy+' '+h2+':42:34';
                   
  ad9_end= mm+'/'+dd+'/'+yyyy+' '+h2+':42:51';

  var ad9_start_time=Math.round(new Date(ad9_start).getTime() / 1000);

  var ad9_end_time=Math.round(new Date(ad9_end).getTime() / 1000);
  slots[i][0]=ad9_start_time;
  slots[i][1]=ad9_end_time;
   i++;

   
  slots[i]=new Array(); 
  ad10_start = mm+'/'+dd+'/'+yyyy+' '+h2+':59:39';
                   
  ad10_end= mm+'/'+dd+'/'+yyyy+' '+h2+':59:56';

  var ad10_start_time=Math.round(new Date(ad10_start).getTime() / 1000);

  var ad10_end_time=Math.round(new Date(ad10_end).getTime() / 1000);
  slots[i][0]=ad10_start_time;
  slots[i][1]=ad10_end_time;
   i++;

   
  //we have a sequence of timings after every 3 hours
   h=h+3;

  }



//this function keeps executing every second
setInterval(function(){checkTime();},1000);

function checkTime()
  {

    var n = Date.now(); 
    //get current time every second
    var current_time=Math.round(n/1000);
    
    var j=1;

    

    while(j<81)
  {

    
   
    if(current_time>slots[j][0]&&current_time<=slots[j][1])
         {

            var ga_slot="Slot"+j;
    
            
            ga('send', {
                hitType: 'event',
                eventCategory: 'iAPT AD',
                eventAction: 'listened',
                eventLabel: ga_slot
 

              });



         }
         


         j++;
  }


  }



