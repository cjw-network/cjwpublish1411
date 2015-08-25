# Functions of CjwSiteCjwpublishBundle #


Bundle:        src/Cjw/CjwSiteCjwpublishBundle
ProjectName:   cjwpublish
VarFolder:     ezpublish_legacy/var/cjwpublish
CacheFolder:   ezpublish_legacy/var_cache/cjwpublish
LogFolder:     ezpublish_legacy/var_log/cjwpublish




## Access to english/german frontend and backend siteaccesses

Production:

    http://www.cjwpublish.com/    => en
    http://www.cjwpublish.com/en  
    http://www.cjwpublish.com/de
    
    http://www.cjwpublish.com/admin_en
    http://www.cjwpublish.com/admin_de

Development:  MatchingRule matching begins with www.cjwpublish.com.*/de  is matching de german siteaccess
              => so every developer can be access if the dev computer can be access bei default
              lokal dns entry e.g.  *.fw.lokal and if the vhost matches all *.cjwpublish1411.*
              the following url can be accessed

    http://www.cjwpublish.com.cjwpublish1411dev.fw.lokal/    => en
    http://www.cjwpublish.com.cjwpublish1411dev.fw.lokal/en  
    http://www.cjwpublish.com.cjwpublish1411dev.fw.lokal/de
    
    http://www.cjwpublish.com.cjwpublish1411dev.fw.lokal/admin_en
    http://www.cjwpublish.com.cjwpublish1411dev.fw.lokal/admin_de


## Access to multisite ezpublish console

    php cjwpublish/console-cjwpublish   (php cjwpublish/console-$ProjectName)
 
=> is the same as php ezpublish/console but only for multitsitesetup to call the kernel from src/Cjw/CjwSiteCjwpublishBundle 




## Functions ##

- de / en siteaccess host/uri matching
    
    src/Cjw/SiteCjwpublishBundle/Resources/config/site.yml
    
        ezpublish:
            siteaccess:
                # cjwpublish_user__en
                default_siteaccess: %cjwsite.name.project%_user__en
        
                list:
                    - %cjwsite.name.project%_user__en
                    - %cjwsite.name.project%_user__de
                    - %cjwsite.name.project%_admin__en
                    - %cjwsite.name.project%_admin__de
        
                groups:
                    %cjwsite.name.project%_user_group:
                        - %cjwsite.name.project%_user__en
                        - %cjwsite.name.project%_user__de
                    %cjwsite.name.project%_admin_group:
                        - %cjwsite.name.project%_admin__en
                        - %cjwsite.name.project%_admin__de
        
                # https://doc.ez.no/display/EZP/Siteaccess+Matching
                match:
                    # www.cjwpublish.com.cjwpublish1411.fw.lokal \Cjw\MultiSiteBundle\Matcher\MapHost: => begins_with
                    # www.cjwpublish.com.cjwpublish1411.fw.lokal/de/ => www.cjwpublish.com/de => siteaccess: cjwpublish_user__de
                    # www.cjwpublish.com.cjwpublish1411.fw.lokal/ => www.cjwpublish.com/en/(default) => default uri en => siteaccess: cjwpublish_user__en
                    \Cjw\MultiSiteBundle\Matcher\MapHostURI:
                        www.cjwpublish.com/en/(default): %cjwsite.name.project%_user__en
                        www.cjwpublish.com/de: %cjwsite.name.project%_user__de
                        www.cjwpublish.com/admin_en: %cjwsite.name.project%_admin__en
                        www.cjwpublish.com/admin_de: %cjwsite.name.project%_admin__de
                        cjwpublish.com/en/(default): %cjwsite.name.project%_user__en
                        cjwpublish.com/de: %cjwsite.name.project%_user__de
                        cjwpublish.com/admin_en: %cjwsite.name.project%_admin__en
                        cjwpublish.com/admin_de: %cjwsite.name.project%_admin__de


- Power of CjwPublishToolsBundle - to develop most of ezpublish task like override twig templates with line views,
  and pagenavigator, feedbackforms without coding php (but it is also possible to use the CjwPublishToolsBundle function in your controller code)
  
    @see doc on https://github.com/cjw-network/CjwPublishToolsBundle

- fullview fetch content in twig template (CjwPublishToolsBundle) and display items as lineview

    src/Cjw/SiteCjwpublishBundle/Resources/views/full.html.twig
    
        {% set listChildren = cjw_fetch_content( [ location.id ], { 'depth': '1',
                                                                    'limit': listLimit,
                                                                    'offset': listOffset,
                                                                    'include': [ 'cjw_folder', 'cjw_article', 'cjw_folder_section', 'cjw_file'  ],
                                                                    'language': [],
                                                                    'datamap': false,
                                                                    'count': true } )[ location.id ] %}
        {% set listCount = listChildren['count'] %}
    
        {% for child in listChildren['children'] %}
    
            {#  slow rendering of line view
            
                {{ render( controller( "ez_content:viewLocation", {'location': child, 'viewType': 'line'} ) ) }}
            
            #}
    
            {# fast rendering of line view - uses the same override mechanism from ezpublish from  "ez_content:viewLocation"
               but make a template include and save the subcontroller call which takes between 30 - 100ms #}
            {{ cjw_render_location( {'location': child, 'viewType': 'line'} )  }}
       
        {% endfor %}


- full view with pagenavigator - very easy to use :-)
    
    
        {% if listCount > listLimit %}
            {% include (site_bundle_name ~ ':parts:navigator.html.twig') with { 'page_uri': ezpublish.requestedUriString(),
                                                                                'item_count': listCount,
                                                                                'view_parameters': ezpublish.viewParameters(),
                                                                                'item_limit': listLimit } %}
        {% endif %}
    
    


- breadcrumb

    src/Cjw/SiteCjwpublishBundle/Resources/views/pagelayout.html.twig
    
        {{ include( site_bundle_name ~ ':parts:breadcrumb.html.twig' ) }}

    src/Cjw/SiteCjwpublishBundle/Resources/views/parts/breadcrumb.html.twig
    
       


- treemenu function 

    src/Cjw/SiteCjwpublishBundle/Resources/views/pagelayout.html.twig:  
    
        {{ include( site_bundle_name ~ ':parts:treemenu.html.twig' ) }}
     
    src/Cjw/SiteCjwpublishBundle/Resources/views/parts/treemenu.html.twig

        {% set treemenu = cjw_treemenu( locationId, {
                                                  'depth': '2',
                                                  'offset': '1',
                                                  'include': [ 'cjw_article', 'cjw_folder', 'cjw_feedback_form' ],
                                                  'sortby': { 'LocationPriority': 'ASC' },
                                                  'datamap': false } ) %}



- cjw_feedback_form => with infocollector using CjwPublishToolsBundle with ezpublish classmapping to symfony form handling

    - symfony form validation is used
    - symfony form rendering is used

    => ez contenttype cjw_feedback_form  => with infocollector attributes => will be render a symfony form which will
    store content into infocollector table and will send an email

    Define custom formbuilder.yml which will be load for this project
    
    src/Cjw/SiteCjwpublishBundle/app/config/parameters.yml
    
        parameters:
            # Filepath + -name for formbuilder Config, from EZROOT directory => sitaccessaware config
            # set default config for all siteaccesses can be overitten by siteaccess or siteaccessgroup if you 
            # need a separate formbuilderconfig
            cjw_publishtools.default.formbuilder.config_file: src/Cjw/SiteCjwpublishBundle/Resources/config/formbuilder.yml


.
    example for defining an infocollector for of ezpublish content type / class  'cjw_feedback_form
    src/Cjw/SiteCjwpublishBundle/Resources/config/formbuilder.yml
    
        
        ...
        formcollector_config:
            parameters:
                button_config:
                    save_button:
                        label:  cjw_publishtools.formbuilder.default.button.send
                    cancel_button: false
            types:
                cjw_feedback_form:
                    handler:
                        infocollector:
        #                sendmail:
        #                    email_sender: @email
        #                    email_subject: @subject
                        success:
                            template: :form:success.html.twig
    

- translations for static strings => formbuilder use the trans system from symfony
 
    src/Cjw/PublishToolsBundle/Resources/translations/messages.de.yml
    src/Cjw/PublishToolsBundle/Resources/translations/messages.en.yml
    
    cjw_publishtools.formbuilder.register.button.save  => will be return  'Send' or 'Abschicken' in english / german context
 
- enable custom exception handling to get correct 404 status code with custom template => 404.html.twig
 
 
 src/Cjw/SiteCjwpublishBundle/app/config/parameters.yml
 
 
    parameters:
     
        # default error page for Exeptionlistener - can be override by siteaccess - it is a siteaccess aware config
        cjw_publishtools.default.eventlistener.exception.template: %cjwsite.name.bundle%:exception:error.html.twig
    
     
    services:
    
        # Show exceptions/errors in self defined template
        cjw_publishtools.eventlistener.exception:
            class: Cjw\PublishToolsBundle\EventListener\ExceptionListener
            arguments: [@templating, @kernel, "$eventlistener.exception.template;cjw_publishtools$"]
            tags:
                - { name: kernel.event_listener, event: kernel.exception, method: onKernelException }

 

## Performance ##

- cjw_render_location vs subcontroller calls e.g.  render( controller(  calls in twig  => every subcontroller call costs a lot of time
  between 30 - 100s so for a loop with 10 line view you can often save 1s !!!!! if you use a normal template include or our
  cjw_render_location twig function which uses the override system from ez like the  render( controller( "ez_content:viewLocation", {'location': child, 'viewType': 'line'} uses
- avoid stash calls if you can e.g. to give the location or content as an parameter in stead of the location id

=> path
=> line view


