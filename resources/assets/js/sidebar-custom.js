$(function() {
  'use strict';
  
  // Date& time
	var datetime = null,
	datetime2 = null,
    date = null;
    let update = () => {
        date = moment(new Date())
        datetime.html(date.format('HH:mm'));
        datetime2.html(date.format('dddd, MMMM Do YYYY'));
    };

    $(document).ready(function(){
        datetime = $('.time h1');
        datetime2 = $('.time p');
        update();
        setInterval(update, 1000);
    });
});

let update = () => {
    date = moment(new Date())
    datetime.html(date.format('HH:mm'));
    datetime2.html(date.format('dddd, MMMM Do YYYY'));
};