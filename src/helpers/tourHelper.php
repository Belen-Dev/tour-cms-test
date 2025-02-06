<?php

function tourType($tour){
    switch ($tour->product_type ) {
        case 1:
             print "Accommodation";
        break;
        case 2:
            print "Transport";
        break;
        case 3:
            print "Tour/cruise";
        break;
        case 4:
            print "Day tour";
        break;
        case 5:
            print "Tailor made";
        break;
        case 6:
            print "Event";
        break;
        case 7:
            print "Training";
        break;
        case 9:
            print "Restaurant";
        break;
        default:
            print "Other";
    }
}

function tourDays($tour){   
    if($tour->duration > 1){
        print $tour->duration." days";
    } 
    else { 
        print $tour->duration." day";
    }
}

function tourDescription($tour){
    if($tour->shortdesc != "TBC") {
        print $tour->shortdesc;
    }
}

?>