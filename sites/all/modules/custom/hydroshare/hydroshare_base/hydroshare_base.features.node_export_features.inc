<?php
/**
 * @file
 * hydroshare_base.features.node_export_features.inc
 */

/**
 * Implements hook_node_export_features_default().
 */
function hydroshare_base_node_export_features_default() {
  $node_export = array(
  'code_string' => 'array(
  (object) array(
      \'vid\' => \'143\',
      \'uid\' => \'1\',
      \'title\' => \'HydroShare Help\',
      \'log\' => \'\',
      \'status\' => \'1\',
      \'comment\' => \'1\',
      \'promote\' => \'0\',
      \'sticky\' => \'0\',
      \'vuuid\' => \'6a2d7569-ac48-4bcc-99a3-fbfbc2c0d05f\',
      \'nid\' => \'142\',
      \'type\' => \'page\',
      \'language\' => \'und\',
      \'created\' => \'1373915937\',
      \'changed\' => \'1373915979\',
      \'tnid\' => \'0\',
      \'translate\' => \'0\',
      \'uuid\' => \'ae9cf217-2e8f-46f5-9c2c-fa4084a93dd9\',
      \'revision_timestamp\' => \'1373915979\',
      \'revision_uid\' => \'1\',
      \'body\' => array(
        \'und\' => array(
          array(
            \'value\' => "<h1>HydroShare: An Easier Way to Collaborate</h1>\\r\\n\\r\\nHello scientists, engineers, and researchers of all sorts.  This page tells you about some of the features of HydroShare.  Once you have created an account and logged in, you will notice the main navigation at the top of the page.\\r\\n\\r\\n<h2>Pages within HydroShare</h2>\\r\\n\\r\\n<strong>Dashboard:</strong>  Here you will find the most recent items you have uploaded, access to your profile information, suggestions for people, groups and resources you might be interested in and announcements from the HydroShare team.\\r\\n\\r\\n<strong>My Content:</strong>  Here you will find the complete list of all of the items that you have uploaded to HydroShare.  Click on any of them to get a complete description as well as to access all of the functionality associated with each resource.\\r\\n\\r\\n<strong>Explore:</strong>  Here you will have the ability to discover resources that others have shared on HydroShare.  You can search by keyword, resource type, date, and geographic area.\\r\\n\\r\\n<strong>Collaborate:</strong>  Here you can find groups of researchers that you might be interested in joining.  Or, you can create your own group and invite other HydroShare users to join you.  Within Groups you can collaborate and share resources and participate in discussions related to your content.\\r\\n\\r\\n<strong>Support:</strong>  This page.  Here you will find all of the latest information on how to use HydroShare\\r\\n\\r\\n<h2>What Is HydroShare?</h2>\\r\\n\\r\\nHydroShare is an online, collaborative system being developed for the sharing of hydrologic data and models.  The goal of HydroShare is to enable you to easily discover and access data and models, retrieve them to your desktop or perform analyses in a distributed computing environment that includes grid, cloud or high performance computing model instances as necessary.  You are then be able to publish outcomes (data, results or models) back to the system, sharing with whom you choose and use the system as a platform for collaboration.  HydroShare expands the data sharing capability of the CUAHSI Hydrologic Information System by broadening the classes of data accommodated, expanding capability to include the sharing of models and model components, and taking advantage of social media functionality to enhance information about and collaboration around hydrologic data and models.  \\r\\n\\r\\n<h2>Why Use HydroShare?</h2>\\r\\n\\r\\nFor collaborative data analysis and modeling\\r\\nHydroShare provides a system for putting data resources online in standard formats and tools for the visualization, analysis and sharing of this data.  Data also includes model instances and model programs.  You control who has access to your data.  HydroShare provides social media functionality to enhance collaboration based on shared data and models, including commenting on and rating of resources among users and collaboration groups.\\r\\n\\r\\n<h3>For team data management</h3>\\r\\nHydroShare will help manage in an organized way your team\'s data.  It will serve small (university group) or large (observatory) teams and help nurture data through its life cycle from collection to publication and curation.\\r\\n\\r\\n<h3>To discover and access a broad class of hydrologic data</h3>\\r\\nHydroShare expands the classes of data supported by CUAHSI HIS and plans to facilitate access to multidimensional space-time data, remote sensing data and River Geometry data in formats readily compatible with hydrologic modeling and analysis tools.  Socially mediated data discovery based on who and for what purpose data has been used will enhance the effectiveness of HydroShare data discovery and selection.\\r\\n\\r\\n<h3>For cloud based and high performance computing capability</h3>\\r\\nHydroShare will facilitate online execution of models based on online data taking advantage of preconfigured high performance computing and cloud based modeling services. \\r\\n\\r\\n<h3>Get credit for sharing your data and models when cited by others</h3>\\r\\nHydroShare will provide formal data publication and citation capability to allow data and models you publish to be cited and for you to get credit for these citations.\\r\\n\\r\\n<h3>System Development Status</h3>\\r\\nHydroShare is at an early stage of development.  The social media and resource sharing functionality is under development and we are establishing the basic infrastructure for sharing resources using a few resource types.  Once these foundations are in place the system will be expanded to additional data types and functionality will be built out.  \\r\\n\\r\\n<h2>HydroShare Resources</h2>\\r\\n\\r\\n<h3>About Resources</h3>\\r\\n\\r\\nIn HydroShare everything is a resource.  We define a resource as digital content which includes the science data files or model files and their corresponding metadata information. HydroShare will ultimately support multiple resource types such as time series, geographic feature, geographic raster, multidimensional space time array data (NetCDF), model, document, etc. Currently, HydroShare beta system supports resource types of time series and geographic feature class (or Geoanalytics).  Current resource related functions are described below. \\r\\n\\r\\n<h3>Create a Resource</h3>\\r\\n1) Sign in the HydroShare system with a user account.\\r\\n2) Click on “MY CONTENT”. \\r\\n3) Click on “UPLOAD”.\\r\\n4) Select a type of resource you want to create.\\r\\n5) Enter the “Title” of your resource. \\r\\n6) Choose data files stored in the local computer to upload to the HydroShare system. \\r\\n7) Enter the other metadata information for the resource (optional).\\r\\n8) Click on “Preview” to see how the uploaded data is visualized in the system (optional).\\r\\n9) Click on “Save” to save the uploaded data files and metadata information in the system.\\r\\n\\r\\n<h3>View, Export, Edit, or Delete Resource</h3>\\r\\n1) Sign in the HydroShare system with a user account.\\r\\n2) Click on “MY CONTENT”. \\r\\n3) In the resource table, click on a resource which you want to view. The system will show the “Resource Detail” interface providing visualization, metadata and sharing functionality.\\r\\n\\r\\n<h3>Rate or Comment on a Resource</h3>\\r\\n1) Sign in the HydroShare system with a user account.\\r\\n2) Click on thumbnail image of that resource. \\r\\n3) To rate resource, give the stars to the resource for “Rating”.\\r\\n4) To comment resource, enter the “SUBJECT” and “COMMENT” information, and select a “TEXT FORMAT” for your comment, then click on “Save”.\\r\\n\\r\\n<h2>HydroShare Groups</h2>\\r\\n\\r\\n<h3>About Groups</h3>\\r\\n\\r\\nHydroShare groups are self-forming to allow users who have similar interests to collaborate. Eventually HydroShare will enable users to share their data and models in the group, participate in discussions, and add group blogs, etc. Currently, the HydroShare beta system supports the group related functions described below.\\r\\n\\r\\n<h3>Create Group</h3>\\r\\n1) Sign in the HydroShare system with a user account. \\r\\n2) Click on “COLLABORATE”. \\r\\n3) In the “COLLABORATE” interface, Click on “CREATE GROUP”. \\r\\n4) Enter the “Title” and “Description” (optional) of the group, then click on “Save”. \\r\\n\\r\\n<h3>Filter or Search Group</h3>\\r\\n1) Sign in the HydroShare system with a user account. \\r\\n2) Click on “COLLABORATE”. \\r\\n3) To filter the groups, click on the dropdown list of the “FILTER GROUPS”, chose one filter method. System will show the groups on the right which satisfies the requirement.\\r\\n4) To search a group, under “SEARCH GROUPS”, enter “Name” or “Description” of the group. System will show the groups on the right which satisfies the requirement.\\r\\n\\r\\n<h3>Join Group</h3>\\r\\n1) Sign in the HydroShare system with a user account.\\r\\n2) Find the group you want to join using “Filter GROUPS” or “SEARCH GROUP” function. \\r\\n3) Click on the group name.\\r\\n4) Click on “Request group membership”. \\r\\n",
            \'summary\' => \'\',
            \'format\' => \'full_html\',
            \'safe_value\' => "<h1>HydroShare: An Easier Way to Collaborate</h1>\\n<p>Hello scientists, engineers, and researchers of all sorts.  This page tells you about some of the features of HydroShare.  Once you have created an account and logged in, you will notice the main navigation at the top of the page.</p>\\n<h2>Pages within HydroShare</h2>\\n<p><strong>Dashboard:</strong>  Here you will find the most recent items you have uploaded, access to your profile information, suggestions for people, groups and resources you might be interested in and announcements from the HydroShare team.</p>\\n<p><strong>My Content:</strong>  Here you will find the complete list of all of the items that you have uploaded to HydroShare.  Click on any of them to get a complete description as well as to access all of the functionality associated with each resource.</p>\\n<p><strong>Explore:</strong>  Here you will have the ability to discover resources that others have shared on HydroShare.  You can search by keyword, resource type, date, and geographic area.</p>\\n<p><strong>Collaborate:</strong>  Here you can find groups of researchers that you might be interested in joining.  Or, you can create your own group and invite other HydroShare users to join you.  Within Groups you can collaborate and share resources and participate in discussions related to your content.</p>\\n<p><strong>Support:</strong>  This page.  Here you will find all of the latest information on how to use HydroShare</p>\\n<h2>What Is HydroShare?</h2>\\n<p>HydroShare is an online, collaborative system being developed for the sharing of hydrologic data and models.  The goal of HydroShare is to enable you to easily discover and access data and models, retrieve them to your desktop or perform analyses in a distributed computing environment that includes grid, cloud or high performance computing model instances as necessary.  You are then be able to publish outcomes (data, results or models) back to the system, sharing with whom you choose and use the system as a platform for collaboration.  HydroShare expands the data sharing capability of the CUAHSI Hydrologic Information System by broadening the classes of data accommodated, expanding capability to include the sharing of models and model components, and taking advantage of social media functionality to enhance information about and collaboration around hydrologic data and models.  </p>\\n<h2>Why Use HydroShare?</h2>\\n<p>For collaborative data analysis and modeling<br />\\nHydroShare provides a system for putting data resources online in standard formats and tools for the visualization, analysis and sharing of this data.  Data also includes model instances and model programs.  You control who has access to your data.  HydroShare provides social media functionality to enhance collaboration based on shared data and models, including commenting on and rating of resources among users and collaboration groups.</p>\\n<h3>For team data management</h3>\\n<p>HydroShare will help manage in an organized way your team\'s data.  It will serve small (university group) or large (observatory) teams and help nurture data through its life cycle from collection to publication and curation.</p>\\n<h3>To discover and access a broad class of hydrologic data</h3>\\n<p>HydroShare expands the classes of data supported by CUAHSI HIS and plans to facilitate access to multidimensional space-time data, remote sensing data and River Geometry data in formats readily compatible with hydrologic modeling and analysis tools.  Socially mediated data discovery based on who and for what purpose data has been used will enhance the effectiveness of HydroShare data discovery and selection.</p>\\n<h3>For cloud based and high performance computing capability</h3>\\n<p>HydroShare will facilitate online execution of models based on online data taking advantage of preconfigured high performance computing and cloud based modeling services. </p>\\n<h3>Get credit for sharing your data and models when cited by others</h3>\\n<p>HydroShare will provide formal data publication and citation capability to allow data and models you publish to be cited and for you to get credit for these citations.</p>\\n<h3>System Development Status</h3>\\n<p>HydroShare is at an early stage of development.  The social media and resource sharing functionality is under development and we are establishing the basic infrastructure for sharing resources using a few resource types.  Once these foundations are in place the system will be expanded to additional data types and functionality will be built out.  </p>\\n<h2>HydroShare Resources</h2>\\n<h3>About Resources</h3>\\n<p>In HydroShare everything is a resource.  We define a resource as digital content which includes the science data files or model files and their corresponding metadata information. HydroShare will ultimately support multiple resource types such as time series, geographic feature, geographic raster, multidimensional space time array data (NetCDF), model, document, etc. Currently, HydroShare beta system supports resource types of time series and geographic feature class (or Geoanalytics).  Current resource related functions are described below. </p>\\n<h3>Create a Resource</h3>\\n<p>1) Sign in the HydroShare system with a user account.<br />\\n2) Click on “MY CONTENT”.<br />\\n3) Click on “UPLOAD”.<br />\\n4) Select a type of resource you want to create.<br />\\n5) Enter the “Title” of your resource.<br />\\n6) Choose data files stored in the local computer to upload to the HydroShare system.<br />\\n7) Enter the other metadata information for the resource (optional).<br />\\n8) Click on “Preview” to see how the uploaded data is visualized in the system (optional).<br />\\n9) Click on “Save” to save the uploaded data files and metadata information in the system.</p>\\n<h3>View, Export, Edit, or Delete Resource</h3>\\n<p>1) Sign in the HydroShare system with a user account.<br />\\n2) Click on “MY CONTENT”.<br />\\n3) In the resource table, click on a resource which you want to view. The system will show the “Resource Detail” interface providing visualization, metadata and sharing functionality.</p>\\n<h3>Rate or Comment on a Resource</h3>\\n<p>1) Sign in the HydroShare system with a user account.<br />\\n2) Click on thumbnail image of that resource.<br />\\n3) To rate resource, give the stars to the resource for “Rating”.<br />\\n4) To comment resource, enter the “SUBJECT” and “COMMENT” information, and select a “TEXT FORMAT” for your comment, then click on “Save”.</p>\\n<h2>HydroShare Groups</h2>\\n<h3>About Groups</h3>\\n<p>HydroShare groups are self-forming to allow users who have similar interests to collaborate. Eventually HydroShare will enable users to share their data and models in the group, participate in discussions, and add group blogs, etc. Currently, the HydroShare beta system supports the group related functions described below.</p>\\n<h3>Create Group</h3>\\n<p>1) Sign in the HydroShare system with a user account.<br />\\n2) Click on “COLLABORATE”.<br />\\n3) In the “COLLABORATE” interface, Click on “CREATE GROUP”.<br />\\n4) Enter the “Title” and “Description” (optional) of the group, then click on “Save”. </p>\\n<h3>Filter or Search Group</h3>\\n<p>1) Sign in the HydroShare system with a user account.<br />\\n2) Click on “COLLABORATE”.<br />\\n3) To filter the groups, click on the dropdown list of the “FILTER GROUPS”, chose one filter method. System will show the groups on the right which satisfies the requirement.<br />\\n4) To search a group, under “SEARCH GROUPS”, enter “Name” or “Description” of the group. System will show the groups on the right which satisfies the requirement.</p>\\n<h3>Join Group</h3>\\n<p>1) Sign in the HydroShare system with a user account.<br />\\n2) Find the group you want to join using “Filter GROUPS” or “SEARCH GROUP” function.<br />\\n3) Click on the group name.<br />\\n4) Click on “Request group membership”. </p>\\n",
            \'safe_summary\' => \'\',
          ),
        ),
      ),
      \'rdf_mapping\' => array(
        \'rdftype\' => array(
          \'foaf:Document\',
        ),
        \'title\' => array(
          \'predicates\' => array(
            \'dc:title\',
          ),
        ),
        \'created\' => array(
          \'predicates\' => array(
            \'dc:date\',
            \'dc:created\',
          ),
          \'datatype\' => \'xsd:dateTime\',
          \'callback\' => \'date_iso8601\',
        ),
        \'changed\' => array(
          \'predicates\' => array(
            \'dc:modified\',
          ),
          \'datatype\' => \'xsd:dateTime\',
          \'callback\' => \'date_iso8601\',
        ),
        \'body\' => array(
          \'predicates\' => array(
            \'content:encoded\',
          ),
        ),
        \'uid\' => array(
          \'predicates\' => array(
            \'sioc:has_creator\',
          ),
          \'type\' => \'rel\',
        ),
        \'name\' => array(
          \'predicates\' => array(
            \'foaf:name\',
          ),
        ),
        \'comment_count\' => array(
          \'predicates\' => array(
            \'sioc:num_replies\',
          ),
          \'datatype\' => \'xsd:integer\',
        ),
        \'last_activity\' => array(
          \'predicates\' => array(
            \'sioc:last_activity_date\',
          ),
          \'datatype\' => \'xsd:dateTime\',
          \'callback\' => \'date_iso8601\',
        ),
      ),
      \'cid\' => \'0\',
      \'last_comment_timestamp\' => \'1373915937\',
      \'last_comment_name\' => NULL,
      \'last_comment_uid\' => \'1\',
      \'comment_count\' => \'0\',
      \'notifications_status\' => \'1\',
      \'name\' => \'admin\',
      \'picture\' => \'61\',
      \'data\' => \'a:2:{s:15:"invite_accepted";b:1;s:7:"overlay";i:1;}\',
      \'path\' => array(
        \'pid\' => \'17\',
        \'source\' => \'node/142\',
        \'alias\' => \'help\',
        \'language\' => \'und\',
      ),
      \'menu\' => NULL,
      \'node_export_drupal_version\' => \'7\',
    ),
)',
);
  return $node_export;
}
