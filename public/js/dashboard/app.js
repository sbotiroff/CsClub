(function(){
    const main = document.querySelector('main');
    // links
    const events = main.querySelector('#events');
    const opportunity = main.querySelector('#opportunity');
    const faq = main.querySelector('#faq');
    const clubLeaders = main.querySelector('#clubLeaders');
    const users = main.querySelector('#users');
    const announcement = main.querySelector('#announcement');
    const about = main.querySelector('#about');
    // app render canvas
    const root = main.querySelector('#root');

    // routes

    events.addEventListener('click', eventsModule.render);

    opportunity.addEventListener('click', opportunityModule.render);

    faq.addEventListener('click',faqModule.render);

    clubLeaders.addEventListener('click',leadersModule.render);
    
    users.addEventListener('click', usersModule.render);

    announcement.addEventListener('click', announcementsModule.render);

    about.addEventListener('click',aboutModule.render);

    

})()