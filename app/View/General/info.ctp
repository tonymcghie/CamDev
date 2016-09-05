<!--
<h1>Information: Chemical Analysis Metadata (CAM)</h1>
<p>Chemical Analysis Metadata (CAM) is a series of web pages that provide access a database containing metadata about the samples sets that have been analysed by the Biological Chemistry & Bioactives Group.
    This metadata includes information about: the sample set such as PFR submitter (or collaborator), sample type, target compounds and more; processes and methods used for analysis; and location of the resulting
    data and derived files. There are two main ways to use these web pages.</p>

<p>1)  For Staff, the page provides a chemistry workbench for PFR staff or non-chemists.  The central unit of work in the CAM database is the 'samples set' and this page provides a selection of actions
    that can be applied to sample sets. This includes initiating a new sample set and the ability to review, edit or add to the metadata as required.  Users can locate metadata about samples sets using
    the Find action.  In this way to is possible to locate all samples sets pertaining to a given crop, chemist,  specific analyte etc. </p>



<p>2) For Chemists, the page provides a chemistry workbench for PFR chemists.  It is essentially the same as the staff page with additional editing functions for set analytical metadata and adding/editing
    compounds in the compounds table. </p>

<p>Click on the buttons (or text links) to activate actions. Below is a brief summary of what each action does and how it can be used.</p>

<p><b>New Set:</b> initiates a new sample set so that metadata about the samples can be entered and stored in the database.</p>
-->
<!--<p><b>Edit MetaData:</b> for reviewing the metadata of an existing sample set and editing or adding to the information as required. It can be used as an collaboration to exchange information about the
    sample set bewteen staff and chemists. To access the metadata the 'set_code' is required.  The set codes can be obtained using the Find actions.</p>-->
<!--
<p><b>Find Set:</b> searches for samples sets using a combination of up to four search criteria.  Samples sets are listed and the set code can be noted of use in other actions. From here you can also got to
    pages to <b>View</b> the data <b>Edit</b> the metadata and if your a chemist edit the <b>Analyses</b></p>

<!--<p><b>Analyze Set:</b> (chemists only) Initiate an analysis and collects information about the analysis methods, procedures and the data produced. To begin an analysis you need to first enter a set code,
    which can obtained using the Find actions.</p>--><!--

<p style="font-size: 14pt; line-height: 1.5em;"><b>This is a work-in-progress - all comments appreciated.</b></p>

<p style="font-size:12pt;">Created by Andrew McGhie, Tony McGhie and Helge Dzierzon</p>

-->
<!--##General Tools

login with PFR details This will give access to creating a new Sample Set and editing Sample Sets. Only Chemists have access the analysis page. The rest of the pages are avalible without logging in.
There is buttons above the CAM title to the right of the login and off menu on the side bar to pick the color scheme that suits your preference.

##Sample Set tools

###New Sample Set

logging in will make your name automatically appear in the name field.
To create a Sample Set similar to a previous Sample Set check the From previous Sample Set button and enter the set code of that sample this will result in the form automatically entering the values from that sample for you to edit.
The Chemist input box as an auto complete function with all the chemists names. start typing a name and the option should appear below the box. You must enter a valid Chemists name are you wont be able to submit
If the Sample Set requires containment check the Containment check box and a details box will appear where you can enter why the Sample Set needs to be contained and details about it.

###Search Sample Set
This is how you get to the edit view and if your a chemist analysis page.
You can add multiple different criteria joined by and leaving the criteria option to the default "Select Criteria" will mean that that row will be excluded from the search
To search via data check the date checkbox and date options will appear.
clicking on the colum headers in the results table will result in ordering by that colum.

###Edit Sample Set
Edit the values the form is basically the same as the new Sample Set form, however every time you edit it a new version will be created wich can be selected from the select input at the top right of the Form. If you are a chemist there will also be a button that goes to analysis

###View Sample Set
allows read only viewing of a Sample Set also shows the derived data from the analysis page so that non chemists can see it.

##Compounds

###Search
search based on exact mass or name. Can decide what mass type.
results can be orded by colum.

###New Compund
add a compund

##PFD data
A big list of previous experiments done at PFR serching works the same way as searching a sample set.

##Metabolite-->

<style> /** sets the styles here as they wont be used any where else */


    p{
        font-size: 1em;
    }
    h3{
        font-size: 1.2em;
    }

    .buttonName{
        font-style: oblique;
        font-size: 1em;
        width: inherit;
        vertical-align: inherit;
    }

.nav-tabs {border-bottom: 0}
.nav li {  margin-right: 2px; border: 2px solid white; border-top-left-radius: 5px; border-top-right-radius: 5px; cursor: pointer;  font-weight: 400}
.nav-tabs>li>a { color: #777; font-weight: 500; z-index:99; background-color: rgba(249,249,249, 0.1); }
.currentTab a { z-index:100; background-color: rgba(249,249,249, 0.5)!important}
.nav li.currentTab{ border-bottom: 3px solid rgba(249,249,249, 0.5);}
header {padding-bottom: 0}
</style>
<header>
<h1>Info</h1>
<ul class="nav nav-tabs">
    <li id="generalTab" class="currentTab" onclick="swap('general')"><a href="#">General</a></li> <!-- sets this to start as the current tab -->
    <li id="samplesetTab" onclick="swap('sampleset')"><a href="#">Sample Sets</a></li>
    <li id="compoundsTab" onclick="swap('compounds')"><a href="#">Compounds</a></li>
    <li id="PFRdataTab" onclick="swap('PFRdata')"><a href="#">PFR Data</a></li>
    <li id="metabolitesTab" onclick="swap('metabolites')"><a href="#">Unknown Compounds</a></li>
</ul>



</header>



<div class="info">
<div id="general">
    <h2>General</h2>

    <p>If you are not logged in already you will be redirected to the login page when you first start CAM. You use your PFR details to login here. There is guest access to all of CAM except the edit and new sample set page as well as the analysis page.  Chemists only can access the Analysis page, however any resulting data will be available for download from the sample set 'View' page.</p>

    <h3>Different Views</h3>
    <p>You have the choice of four  colour schemes. You can choose between them by clicking on the 4 circles above the CAM title on the sidebar. Also up there is the button to switch from the touch screen friendly view and the normal desktop view. The touch screen friendly view only effect the Add Metabolite, Analysis and New Sample Set pages as well as the sidebar. The touch screen view splits the pages and allows you to swipe left and right between the segments. The sidebar will also automatically hide when you click on the page.</p>

    <h3>Logic</h3>
    <p>the logic on the searching works by grouping together the values with the same logic setting (ie. all the ones with OR grouped) then each group is combined by an AND.  This means that to get to values to be connected by OR you will need to set both logic selects to OR.</p>

    <h3>Scripts</h3>
    <p>Only chemists can access this page. It contains a number of python scripts for working with CSV and Excel files. This works by the user uploading a file, applying the script to the files, then downloading the output file back to their computer.</p>

    <h3>Created By</h3>
    <ol>
        <li>Andrew McGhie</li>
        <li>Tony McGhie</li>
        <li>Helge Dzierzon</li>
    </ol>
</div>
<div id="sampleset" style="display: none;">
    <h2>Sample Sets</h2>

    <h3>New</h3>
    <p>To create a new sample set make sure you are logged in then press the <span class="buttonName">new</span> sample set button on the sidebar. From here you can import values from a previous sample set by checking the Previous set code checkbox. When you enter the set code the values will be automatically loaded. Your name will be automatically filled in. Continue entering information into the data fields. Fields with an asterisk next to their name have to be filled out to create a new sample set. Please note that on most browsers the large text areas sizes can be changed if you find it easier. Just click and drag on the bottom right of the text area. The chemist’s field will require you to enter a valid name for one of the chemists. It will come up with their names to click on when you start typing in this field. When you check the require containment checkbox a text area will appear for you to enter the details of the containment required. After you have finished click save and the Set Code for the new sample setwill be displayed at the top of the page. The Set Code is automatically generated and is a unique identifier for this sample set.</p>

    <h3>Search</h3>
    <p>To search for a sample set select the criteria you want to search on then enter the value and click <span class="buttonName">search</span>. To search between two dates check the search by that check box. To add more search criteria options click the <span class="buttonName">add search criteria</span> button. After you click the <span class="buttonName">search</span> button the first 20 results will be displayed beneath with links to more sets of 20.</p>

    <h3>Edit</h3>
    <p>The edit sample set page is similar to the new sample set page however there are a few major differences. There is a drop down box containing the version numbers this will default to the most recent version. To go back to a previous version select the version you want to go back to, the values will appear in the form, then click <span class="buttonName">save</span> and you will save a new version with the values that are currently displayed. You will also notice that values like Set Code, chemist, and team are not able to be edited; these are fixed. If you are a Chemist, there will be a button at the top of the page that will take you to the analysis page for that sample set.</p>

    <h3>View</h3>
    <p>This is a page set up for you to view a Sample Set this is also where the non-chemist have access to the data from the analysis.  Everyone (all of PFR) has access to this page as you don’t have to be logged in. However this page is for viewing only and nothing can be edited.</p>

    <h3>Analysis</h3>
    <p>Chemists only can access the analysis page. The analysis form contains all the information for a specific analysis of the sample set. To create a new analysis there is a plus button tab thing which will bring up an overlay where you can enter the title for a new analysis and select the type of workflow of the new analysis. There can be multiple analyses per samples set. The analysis form has the capability of uploading files. Uploaded files are stored on the PowerPlant server. Multiple images can be uploaded. You can browse images by clicking on the left and right side of the currently displayed image to move forward of back through the list of images. Data files can also be uploaded and stored on PowerPlant.  Two type of files can be uploaded; processed and additional data. Processed data should be either csv or xlsx files and will be saved as xlsx. Upon uploading a cover sheet will be added to the file containing the current information entered on the Sample Set page. If you don’t want a Cover Sheet added, simply already have a sheet in the document called 'Cover Sheet'. Additional data can be any type of file.  Files stored on PowerPlant server can be downloaded then uploaded again to update the files.</p>
</div>
<div id="compounds" style="display: none;">
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
<div id="PFRdata" style="display: none;">
    <h2>PFR data</h2>

    <h3>Find</h3>
    <p>All PFR staff can search the PFR compounds Database. The Search function has be designed so that the desired results can be found using a combination of search criteria.  Logical operators can be used to specifically find a given set of data.  Once the desired data set have be displayed, the data can be downloaded as an Excel file for further data processing of graphing as required. If you search on compound name CAM will first search the compounds database and add adding synonyms that are present in the Compounds table.

    <h3>Graph</h3>
    <p>Graphing data works in a similar way to the Search function. Firstly you need to use the search criteria to select the required dataset for the database.  Then the graphing options that are desired. To graph data select the values for the x and y axis then the chart type. Scatter charts are the only charts type that can take more than one set. Any other kind of chart will only search on and display what is entered in the first set. Click the <span class="buttonName">Add Set</span> button to add a Set then <span class="buttonName">add search criteria</span> to add a search input box with criteria value and logic options. When you select the pivot option the x and y axis will be automatically selected; the y axis will be set to intensity value and the x axis to whatever option you chose.</p>

    <h3>Import</h3>
    <p>Chemists can import data into the PFR compounds Database from a CSV file using this page. CSV files can be created by choosing to save an xlsx file as a CSV in Microsoft Excel. Click the <span class="buttonName">choose file</span> input and brows your computer for the CSV file. It will then load a preview of the file (the first 6 rows of data) if the loading was successful. You can then match up the columns in the database with the columns in you CSV file and click <span class="buttonName">import</span> and the data will be uploaded into the database. The filename that it came from will be recoded alongside the data in the data base so it is possible (if you made a mistake) to contact the administrator (probably Tony McGhie) and get the data removed you can also search for it in the PFR data search page </p>
    </div>
<div id="metabolites" style="display: none;">
    <h2>Unknown Compounds</h2>
    <h3>Add</h3>
    <p>Add an Unknown Compound, MSMS or proposed ID (one at a time)</p>

    <h3>Search</h3>
    <p>search for Unknown Compound</p>

    <h3>Edit</h3>
    <p>edit the data entered</p>
</div>
</div>


<script>
    //the ids of the div that make the tabs
    ids = ['general', 'sampleset', 'compounds', 'PFRdata', 'metabolites'];

    /**
     * switches which div is showing
     * @param {type} id
     * @returns null
     */
    function swap(id){
        for(i = 0;i<ids.length;i++){
            if (ids[i] === id)continue;
            if (!$('#'+ids[i]).is(":visible"))continue;
            $('#'+ids[i]).fadeOut('fast',function(){
                $('#'+id).fadeIn('fast');
            });
            $('#'+ids[i]+'Tab').attr('class', '');
            $('#'+id+'Tab').attr('class', 'currentTab');
        }
    }
</script>
