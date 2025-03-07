<?php
/**
 * MVOC event functions
 *
 * Utility functions for rendering events
 *
 */

const MVOC_DISTANCE_KEY = '_mvoc_distance';
const MVOC_BOF_ID_KEY = '_mvoc_bof_id';
const MVOC_LATITUDE_KEY = '_mvoc_latitude';
const MVOC_LONGITUDE_KEY = '_mvoc_longitude';
const MVOC_W3W_KEY = '_mvoc_w3w';
const MVOC_ONLINE_ENTRY_KEY = '_mvoc_online_entry';

function mvoc_event_tag_icons($event_id, $align='right') {
    $result = '';
    $posttags = get_the_tags($event_id);
    $div_class = 'mvoc-event-tag-' . $align;
    if ($posttags) {
        foreach($posttags as $tag) {
            switch (strtolower($tag->name)) {
                case 'mvoc': 
                    $inner_text = '<i class="fa-brands fa-swift fa-flip-horizontal" style="color: #16A1E7;"></i>';
                    $hint_text = 'Event of particular importance to Mole Valley members, usually either organised by Mole Valley or featuring some form of inter-club competition';
                    break;
                case 'night': 
                    $inner_text = '<i class="fa-solid fa-moon" style="color: #9d9e9d;"></i>';
                    $hint_text = 'Night event';
                    break;
                case 'ranking': 
                    $inner_text = '<i class="fa-solid fa-ranking-star" style="color: #e67512;"></i>';
                    $hint_text = 'British Orienteering National Ranking event';
                    break;
                case 'national': 
                    $inner_text = '<i class="fa-solid fa-flag" style="color: #7f1796;"></i>';
                    $hint_text = 'Event graded by British Orienteering as ¨National¨ (if not in the UK Orienteering League)';
                    break;
                case 'trailo': 
                    $inner_text = '<i class="fa-solid fa-wheelchair-move"  style="color: #17ada8;"></i>';
                    $hint_text = 'Event contains Trail-O, possibly only as an optional component of a mainly Foot-O event';
                    break;
                case 'major': 
                    $inner_text = '<i class="fa-solid fa-star" style="color: #dbaf0f;"></i>';
                    $hint_text = 'National Championship, UK Orienteering League event, or other event graded by British Orienteering as ¨Major¨';
                    break;
                case 'online': 
                    $onlineentryurl = get_post_meta($event_id, MVOC_ONLINE_ENTRY_KEY, true);
                    if ($onlineentryurl) {
                        $inner_text = '<a target="_blank" rel="noopener" href="' . $onlineentryurl . '"><i class="fa-solid fa-laptop" style="color: #2e9617;"></i></a>';
                    } else {
                        $inner_text = '<i class="fa-solid fa-laptop" style="color: #2e9617;"></i>';
                    }
                    $hint_text = 'On-line entries have opened';
                    break;
                case 'preentry': 
                    $inner_text = '<i class="fa-solid fa-envelope-open-text" style="color: #26b017;"></i>';
                    $hint_text = 'On-line pre-entry opening, closing or price change date';
                    break;											
                case 'overseas': 
                    $inner_text = '<i class="fa-solid fa-plane" style="color: #ba0a04;"></i>';
                    $hint_text = 'Overseas event';
                    break;
                case 'summer series': 
                    $inner_text = '<i class="fa-solid fa-sun" style="color: #ffc800;"></i>';
                    $hint_text = 'Part of the MV Summer Series';
                    break;
                case 'winter series': 
                    $inner_text = '<i class="fa-solid fa-snowflake" style="color: #a0a0a0;"></i>';
                    $hint_text = 'Part of the MV Winter Series';
                    break;
                case 'cancelled': 
                    $inner_text = '<i class="fa-solid fa-circle-xmark" style="color: #ff0000;"></i>';
                    $hint_text = 'Event cancelled';
                    break;
                case 'streeto': 
                    $inner_text = '<i class="fa-solid fa-road" style="color: #606060;"></i>';
                    $hint_text = 'Street Orienteering';
                    break;                
                default:
                    $inner_text = $tag->name;
                    $hint_text = '';
                    break;
            }
            $result = $result . '<div class="'. $div_class. '" title="' . $hint_text .'">' . $inner_text . '</div>'; 
        }
    }

    $latitude = get_post_meta($event_id, MVOC_LATITUDE_KEY, true);
    $longitude = get_post_meta($event_id, MVOC_LONGITUDE_KEY, true);
    $w3w = get_post_meta($event_id, "_mvoc_w3w", true);
    $w3wurl = null;
    if (empty($w3w)) {
        $w3wurl = w3w_lat_lon_url($latitude, $longitude);
    } 
    else {
        $w3wurl = w3w_url($w3w);
    }
    if ($w3wurl) {
        $inner_text = '<a target="_blank" rel="noopener" href="' . $w3wurl . '"><i class="fa-solid fa-map-pin event-icon" style="color: #25A2E4;"></i></a>&nbsp;';
        $hint_text = 'W3W';
        $result = $result . '<div class="'. $div_class. '" title="' . $hint_text .'">' . $inner_text . '</div>'; 
    }

    $streetmapurl = streetmap_url($latitude, $longitude);
    if ($streetmapurl) {
        $inner_text = '<a target="_blank" rel="noopener" href="' . $streetmapurl . '"><i class="fa-solid fa-map event-icon" style="color: #25A2E4;"></i></a>&nbsp;';
        $hint_text = 'StreetMap';
        $result = $result . '<div class="'. $div_class. '" title="' . $hint_text .'">' . $inner_text . '</div>'; 
    }

    $gmapurl = gmap_url($latitude, $longitude);
    if ($gmapurl) {
        $inner_text = '<a target="_blank" rel="noopener" href="' . $gmapurl . '"><i class="fa-solid fa-map-location-dot event-icon" style="color: #25A2E4;"></i></a>&nbsp;';
        $hint_text = 'Google Map';
        $result = $result . '<div class="'. $div_class. '" title="' . $hint_text .'">' . $inner_text . '</div>'; 
    }

    return $result;    
}

const min_lat = 49.9;
const max_lat = 61.0;
const min_lon = -6.5;
const max_lon = 2.0;

function is_in_uk($latitude, $longitude) {
  if (is_numeric($latitude) && is_numeric($longitude)) {
    return ($latitude >= min_lat) && ($latitude <= max_lat) && ($longitude >= min_lon) && ($longitude <= max_lon);
  }
  else {
    return false;
  }
}


function gmap_url($latitude, $longitude) {
    // example https://www.google.co.uk/maps/place/51.0725,0.0468
    if (is_numeric($latitude) && is_numeric($longitude)) {
        return 'https://www.google.co.uk/maps/place/' . $latitude .','. $longitude;
    }
    else {
        return null;
    }
}

function streetmap_url($latitude, $longitude) {
    // example https://streetmap.co.uk/loc/56.1782,-4.3850
    if (is_in_uk($latitude, $longitude)) {
        return 'https://streetmap.co.uk/loc/' . $latitude .','. $longitude;
    }
    else {
        return null;
    }
}

function bof_url($bof_id, $categories) {
    if ($categories) {
        foreach($categories as $category)
        if (str_contains('Activity', $category->name)) {
            return 'https://www.britishorienteering.org.uk/activity?activity=' . $bof_id;
        }
    }
    return 'https://www.britishorienteering.org.uk/event?event=' . $bof_id;
}

function w3w_url($w3w) {
    if ($w3w) {
        return 'https://w3w.co/' . $w3w;
    } 
    else {
        return null;
    }
}

function w3w_lat_lon_url($latitude, $longitude) {
    if (is_numeric($latitude) && is_numeric($longitude)) {
        return 'https://w3w.co/' . $latitude .','. $longitude;
    }
    else {
        return null;
    }
}

// Earth radius in metres for haversine calculation  
const DMMEANRADIUS = 6371000.0;
// LEATHERHEAD: TQ 16368 56325 = 51.294173	-0.33242477
const ORIGIN_LAT = 51.294173;
const ORIGIN_LONG = -0.33242477;
function haversine_dist($lat1, $long1, $lat2, $long2) {
    $hs1 = sin(($lat1-$lat2)/2.0);  
    $hs2 = sin(($long1-$long2)/2.0);  
    return 2.0*DMMEANRADIUS*asin(sqrt($hs1*$hs1+cos($lat1)*cos($lat2)*$hs2*$hs2));  
}

function event_distance($latitude, $longitude) {
    if (is_numeric($latitude) && is_numeric($longitude)) {
        $lat1 = deg_to_rad($latitude);
        $long1 = deg_to_rad($longitude);
        $lat2 = deg_to_rad(ORIGIN_LAT);
        $long2 = deg_to_rad(ORIGIN_LONG);
        $dist_metres = haversine_dist($lat1, $long1, $lat2, $long2);
        return round($dist_metres / 1609);
    }
    else {
        return null;
    }
}

function deg_to_rad($deg) {
    return $deg / 360.0 * 2 * M_PI;
}

