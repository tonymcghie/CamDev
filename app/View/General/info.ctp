<style>
    .nav-tabs > li > a {
        color: #777;
        z-index:1;
    }
</style>
<header>
<h1>Info</h1>
<ul class="nav nav-tabs">
    <li class="active"><a data-toggle="tab" href="#general_tab">General</a></li>
    <li><a data-toggle="tab" href="#sampleset_tab">Sample Sets</a></li>
    <li><a data-toggle="tab" href="#compounds_tab">Compounds</a></li>
    <li><a data-toggle="tab" href="#pfr_data_tab">PFR Compound Data</a></li>
    <li><a data-toggle="tab" href="#metabolomics_data_tab">Metabolomics Data</a></li>
    <li><a data-toggle="tab" href="#unknown_compounds_tab">Unknown Compounds</a></li>
    <li><a data-toggle="tab" href="#tools_tab">Tools</a></li>
     <li><a data-toggle="tab" href="#tips_tab">CAM Tips</a></li>
</ul>
</header>



<div class="tab-content">
    <div id="general_tab" class="tab-pane fade in active">
        <h2>General</h2>

        <p>Use your PFR username and password to login into CAM.</p>
        <p>When you start CAM, if you are not already logged in, you will be redirected to the login page.</p>
        <p>All PFR staff can access CAM, however only Analysts can access the Sample Set>Analysis page and add and edit Compounds. Additionally, Samples Sets that are tagged as "confidential" can only be accessed by the PFR Collaborator, who initiated the Sample Set, and the designated Sample Set Analyst.</p>

        <h3>Actions</h3>
        <p>CAM Actions are activated by clicking on the side-bar commands.  Related Actions are grouped together and more information about each group of Actions can be found in the tabs to the right.</p>

        <h3>Find (Searching)</h3>
        <p>Most CAM Actions start by initiating a Find page, which is used for searching the database.  The Find page contains four inputs: 1) Criteria - a drop down list of fields relevant to the type of data you are searching for; 2) a search value that has to be entered; 3) logic operator; and 4) selection for how the entered search value is treated.  </p>

        <h3>Created By</h3>
        <ol>
            <li>Andrew McGhie</li>
            <li>Tony McGhie</li>
            <li>Helge Dzierzon</li>
            <li>Eric Burgueño</li>
            <li>Jack McKenzie</li>
        </ol>
        <h3>Version: 4.0.beta</h3>
                
    </div>
    <div id="tips_tab" class="tab-pane fade">
        <h2>CAM Tips</h2>
                
        <h3>Find (Searching)</h3>
        <p>The default Match is set to 'Contains' this means the value enter need only contain a portion of the item being searched for.  For example is searching for Compounds only part of the name need be entered.  For example, entering 'quercet' will find all compounds containing the quercetin aglycone.</p>
        <p>To display all data entries of a specific type (e.g. sample sets, compounds, PFR compound data etc) when searching, leave the Value field blank. This will generate a list of all data together with the total number of data records.</p>
       
  
    </div>
    <div id="sampleset_tab" class="tab-pane fade">
        <h2>Sample Sets</h2>

        <h3>New</h3>
        <p>To initiate a new Sample Set use the <u>Sample Set>New</u> action from the side-bar. Your name will be automatically entered into the PFR Collaborator field. Continue entering information into the data fields. Fields with an asterisk next to their name are required to create a new Sample Set. Note, for most browsers the size of the large text areas to be changed making it easier to enter data. To do this click and drag on the bottom right of the text area. The Analyst field will require you to enter the name of an Analyst. Start typing and this field will auto-fill with names, select the appropriate name. When you check the Require Containment checkbox, a text area will appear for you to enter the details of the containment required. After you have finished click Save. If successful the Set Code for the new Sample Set will be displayed at the top of the page. The Set Code is automatically generated and is a unique identifier for this sample set.</p>
        <p>When initiating a new Sample Set you can import values from a previous sample set by checking the Previous set code checkbox.</p>

        <h3>Find</h3>
        <p>To Find a Sample Set use the <u>Sample Set>Find</u> action from the side-bar, select the Criteria you want to search on, enter a Value to search for, then select the Logic and Match values as required. To search between two dates, check the search by date check box. To add more search criteria options click the <u>Add Search Criteria</u> button. After you click the <u>Search</u> button the first 20 results will be displayed beneath with links to more sets of 20. For each Sample Set found, several Actions are available. For a description of what each does see below.</p>
        
        <h3>Import Samples</h3>
        <p>To Import Samples generate a .csv file containing relevant sample information.  Use the Sample Info template avaliable from the Data Templates action to ensure your data is in an appropriate format for Import. Then use this action to Import the sample data. Note, a Sample Set must must exist and the sample data must include a valid Set Code.</p>
        
        <h2>Sample Set Actions</h2>
        <p>Samples Set will be listed as a table following a search, and several Sample Set Actions (presented as buttons) can be used.</p>
        <h3>Edit</h3>
        <p>The edit Sample Set page is similar to the new Sample Set page however there are a few major differences. There is a drop down box containing version numbers that will default to the most recent version. To go back to a previous version, select the version you want to go back to, the values will appear in the form, then click <span class="buttonName">save</span> and you will save a new version with the values that are currently displayed. You will also notice that the entries for Set Code, Analyst, and Team are not able to be edited; these are fixed. If you are a Analyst, there will be a button at the top of the page that will take you to the analysis page for that sample set.</p>

        <h3>View</h3>
        <p>This action allows a user to view a Sample Set and to access Sample Set data (if available).  All PFR staff have access to this page, however, this page is for viewing only and nothing can be edited. Sample Sets that are tagged as 'Confidential' can only be viewed by the initiating  PFR Collaborator and the Sample Set Analyst.</p>

        <h3>Analysis</h3>
        <p>Analysts only can access the Analysis action. The Analysis form contains all the information for a specific analysis of samples in a Sample Set. To create a new Analysis click on the plus button tab. This will display an an overlay where you  enter the title for a new Analysis and select the workflow required. There can be multiple Analyses per Sample Set. Each analysis is displayed as a tab.  The analysis form has the capability of uploading files. Uploaded files are stored on the PowerPlant server. Multiple images can be uploaded. You can browse images by clicking on the left and right side of the currently displayed image to move forward of back through the list of images. Data files can also be uploaded and stored on PowerPlant.  Two type of files can be uploaded; processed and additional data. Processed data should be either csv or xlsx files and will be saved as xlsx. Upon uploading a cover sheet will be added to the file containing the current information entered on the Sample Set page. If you don’t want a Cover Sheet added, simply already have a sheet in the document called 'Cover Sheet'. Additional data can be any type of file.  Files stored on PowerPlant server can be downloaded then uploaded again to update the files.</p>
    </div>
    <div id="compounds_tab" class="tab-pane fade">
        <h2>Compounds</h2>

        <h3>Find</h3>
        <p>Compounds can be searched by name and mass as well as the different masses of the ions. Searching on the name will also search the synonyms and system name fields as well. Once you have the search results you can change the types of masses it is displaying by clicking the radio bottoms above the table. Also in the table there are links to PubChem, ChemSpider, Metlin and flavourNet for each compound accordingly. There is also a button that will display the structure of the compound in both 2D and 3D.</p>

        <h3>Sub-structure Search</h3>
        <p>Sub-structure searching uses Canonical Smiles. The Sub-structure search works by first searching the PubChem database for substructures and then compares the results with the compounds in the CAM Compounds database. A sub-structure search of PubChem often returns a very large number of hits, and the subsequent comparison with CAM Compounds can take a long time.  Therefore make sure your sub-structure is as specific as possible, otherwise the search will take a long time. If you wish to enter a structure of sub-structure search click the Ketcher button and an overlay will appear where you can draw chemical structures there is more information here <a href="http://lifescience.opensource.epam.com/ketcher/help.html" target="_blank">Help Life Sciences 0.3.0 documentation</a> .You can then click the <span class="buttonName">save</span> button at the top beside the new and open buttons select the Smile then copy the text into the search box on the substructure search page.</p>

        <h3>Add</h3>
        <p>Chemists can add compounds by entering the information. When the PubChem CID is entered the mass name and formula fields will be automatically filled in. When the chemist fills in the CAS number, CAM will check the data base to see if that compound is already in the database and inform the chemist with a message above the CAS input box</p>

        <h3>Edit</h3>
        <p>Chemists can edit the information entered in the compounds database table. There is no autocomplete function or checking on the CAS number on the form</p>
    </div>
    <div id="pfr_data_tab" class="tab-pane fade">
        <h2>PFR Compound Data</h2>

        <h3>Find</h3>
        <p>All PFR staff can search PFR Compound Data. The Find action has be designed so that the desired results can be found using a combination of search criteria.  Logical operators and matching can be used to specifically find a given set of data.  Once the desired data set have be displayed, the data can be downloaded as an Excel file for further data processing, analysis and graphing as required. If you search for a compound name, CAM will first search the compounds database adding synonyms that are present in the Compounds table to the search criteria.

        <h3>Graph</h3>
        <p>The Graphing action works in a similar way to the Find action. Firstly, you need to use the search criteria to select the required dataset from the database.  Then select the graphing options that are desired. To graph data select the values for the x and y axis then the chart type. Scatter charts are the only charts type that can take more than one set. Any other kind of chart will only search on and display what is entered in the first set. Click the <span class="buttonName">Add Set</span> button to add a Set then <span class="buttonName">add search criteria</span> to add a search input box with criteria value and logic options. When you select the pivot option the x and y axis will be automatically selected; the y axis will be set to intensity value and the x axis to whatever option you chose.</p>

        <h3>Import</h3>
        <p>Refer to the Import How To for further information on Importing Compound Data.  Analysts can Import data into  PFR Compounds Data from a CSV file using this action. CSV files can be created by choosing to save an xlsx file as a CSV in Microsoft Excel. Click the <span class="buttonName">choose file</span> input and browse your computer for the CSV file. It will then load a preview of the file (the first 6 rows of data) if the loading was successful. You then need to match the columns in the database with the columns in you CSV file. Unwanted columns in the CSV file can be ignored by setting to 'Dont Import'.  When you are satisfied with the mapping, click <span class="buttonName">Import</span> and the data will be uploaded into the database. The filename of the file that contained the data is recorded with the data so it is possible (if you made a mistake) to contact the administrator (probably Tony McGhie) and get the data removed. You can also use the filename to search specifically for the data using the Find action. </p>
        </div>
    <div id="metabolomics_data_tab" class="tab-pane fade">
        <h2>Metabolomics Data</h2>

        <h3>Find</h3>
        <p>All PFR staff can search Metabolomic Data. The Find action has be designed so that the desired results can be found using a combination of search criteria.  Logical operators and matching can be used to specifically find a given set of data.  Once the desired data set have be displayed, the data can be downloaded as an Excel file for further data processing, analysis and graphing as required. 

         <h3>Import</h3>
        <p>Analysts can Import data into the Metabolomics Data from a CSV file using this action. The process is similar to Importing PFR Compound Data - refer to PFR Compound Data for instructions.</p>
        </div>
    <div id="unknown_compounds_tab" class="tab-pane fade">
        <h2>Unknown Compounds</h2>
        <h3>Add</h3>
        <p>Add an Unknown Compound, MSMS or proposed ID (one at a time). An Unknown Compound must be registered before MSMS data or a Proposed ID can be entered.  A Unknown Compound ID must be used when entering MSMS data or a Proposed ID.</p>

        <h3>Search</h3>
        <p>Search for Unknown Compound</p>

        <h3>Edit</h3>
        <p>Edit the data that has been entered for and Unknown Compound.</p>
    </div>
    <div id="tools_tab" class="tab-pane fade">
        <h2>Tools</h2>
        <h3>Scripts</h3>
        <p>Python scripts can be accessed from the Scripts action.  The current scripts provide a convenient way to transpose summary (compound or metabolomic) data into a format that can be imported into CAM.</p>

        <h3>GCMS Utilities</h3>
        <p>This action provides access to links that were available in the legacy Compounds Database.  These utilities convert output files from GCMS instruments into alternative formats.</p>

        <h3>Data Templates</h3>
        <p>Spreadsheet (xlsx, csv) templates can be downloaded using this action.  The templates are: 1) Sample Info Upload; 2) Compound Data Summary table; 3) Compound Data Upload Specifications; 4) Metabolomics Data Upload Specifications; and 5) Data Processing.</p>
        
        <h3>New Project</h3>
        <p>When initiating a new Sample Set, the Project field will auto-fill.  However, a Project must first be entered and saved before hand. This can be achieved using the form found in the New Project action</p>
        
        <h3>Feedback</h3>
        <p>When issues are encountered with CAM, these can be logged for attention by completing and submitting the form found in the Feedback action.</p>
        
        <h3>Clear Workbench</h3>
        <p>Clears the workbench leaving the background image visable.</p>
    </div>
</div>

