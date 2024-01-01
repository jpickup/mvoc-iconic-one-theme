<?php
/**
 * MVOC event functions
 *
 * Utility functions for rendering events
 *
 */

function mvoc_event_tag_icons($event_id, $align='right') {
    $result = '';
    $posttags = get_the_tags($event->ID);
    $div_class = 'mvoc-event-tag-' . $align;
    if ($posttags) {
        foreach($posttags as $tag) {
            switch (strtolower($tag->name)) {
                case 'mvoc': 
                    $inner_text = '<i class="fa-brands fa-swift fa-flip-horizontal" style="color: #3773ff;"></i>';
                    $hint_text = 'Event of particular importance to Mole Valley members, usually either organised by Mole Valley or featuring some form of inter-club competition';
                    break;
                case 'night': 
                    $inner_text = '<i class="fa-solid fa-moon"></i>';
                    $hint_text = 'Night event';
                    break;
                case 'ranking': 
                    $inner_text = '<i class="fa-solid fa-ranking-star"></i>';
                    $hint_text = 'British Orienteering National Ranking event';
                    break;
                case 'national': 
                    $inner_text = '<i class="fa-solid fa-flag"></i>';
                    $hint_text = 'Event graded by British Orienteering as ¨National¨ (if not in the UK Orienteering League)';
                    break;
                case 'trailo': 
                    $inner_text = '<i class="fa-solid fa-wheelchair-move"></i>';
                    $hint_text = 'Event contains Trail-O, possibly only as an optional component of a mainly Foot-O event';
                    break;
                case 'major': 
                    $inner_text = '<i class="fa-solid fa-star"></i>';
                    $hint_text = 'National Championship, UK Orienteering League event, or other event graded by British Orienteering as ¨Major¨';
                    break;
                case 'online': 
                    $inner_text = '<i class="fa-solid fa-laptop"></i>';
                    $hint_text = 'On-line entries have opened';
                    break;
                case 'preentry': 
                    $inner_text = '<i class="fa-solid fa-envelope-open-text"></i>';
                    $hint_text = 'On-line pre-entry opening, closing or price change date';
                    break;											
                case 'overseas': 
                    $inner_text = '<i class="fa-solid fa-plane"></i>';
                    $hint_text = 'Overseas event';
                    break;
                default:
                    $inner_text = $tag->name;
                    $hint_text = '';
                    break;
            }
            $result = $result . '<div class="'. $div_class. '" title="' . $hint_text .'">' . $inner_text . '</div>'; 
        }
    }
    return $result;    
}
?>
