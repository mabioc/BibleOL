// -*- js -*-
// Copyright © 2018 by Ezer IT Consulting. All rights reserved. E-mail: claus@ezer.dk

// This code provides information about Bootstrap's current concept of the browser window size.
// This code is placed in the namespace 'resizer'.

// The idea for some of the following code is taken from
// http://stackoverflow.com/questions/18575582/how-to-detect-responsive-breakpoints-of-twitter-bootstrap-3-using-javascript



namespace resizer {

    //************************************************************************************************
    // getWindowSize function
    //
    // Returns the current browser window size, using the Bootstrap size indicators 'xs', 'sm',
    // 'md', 'lg', or 'xl'.
    //
    export function getWindowSize() : string {
        return $('.device-sizer:visible').attr('data-size');
    }

    //************************************************************************************************
    // sizeIs function
    //
    // Checks if the current browser window has a particular Bootstrap size.
    //
    // Parameter:
    //      siz: Bootstrap size indicator ('xs', 'sm', 'md', 'lg', or 'xl').
    // Returns:
    //      True if the browser window has the specified size (neither more nor less).
    //
    export function sizeIs(siz : string) : boolean {
        return $('.device-is-' + siz).is(':visible');
    }

    let timers : util.str2num = {};

    //************************************************************************************************
    // addResizeListener function
    //
    // Specifies a function that listens for browser window resizings.
    //
    // Parameters:
    //     callback: A function to call when the browser window is resized. The function is called
    //               with the parameter 'data'.
    //     data: Data to pass as a parameter to the callback function.
    //     uniqueId: Identifies a timer used internally. A separate uniqueId must be given for each
    //               instance that listens for a resize.
    //
    export function addResizeListener(callback : (d:any)=>void, data : any, uniqueId : string) : void {
        // When the browser window resizes, wait for 500 ms and if no further resize occurs, call
        // the callback function

        $(window).resize(() => {
            // If the browser window was recently resized, restart the timer, otherwize start the timer

            if (timers[uniqueId])
                clearTimeout(timers[uniqueId]);

            timers[uniqueId] = setTimeout(() => callback(data), 500); // Call callback in 500 ms
        });
    }

    // Initialization code. Creates empty <div> elements, each of which is only visible when the
    // browser window has a particular size.
    $(function() {
        // Insert size detectors before </body>
        $('body')
            .append(`<div class="d-block            d-sm-none device-is-xs device-sizer" data-size="xs"></div>`)
            .append(`<div class="d-none  d-sm-block d-md-none device-is-sm device-sizer" data-size="sm"></div>`)
            .append(`<div class="d-none  d-md-block d-lg-none device-is-md device-sizer" data-size="md"></div>`)
            .append(`<div class="d-none  d-lg-block d-xl-none device-is-lg device-sizer" data-size="lg"></div>`)
            .append(`<div class="d-none  d-xl-block           device-is-xl device-sizer" data-size="xl"></div>`);
    });
}


