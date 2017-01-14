<style>
    .nav-tabs > li > a {
        color: #777;
        z-index:1;
    }
</style>
<header>
<h1>How To</h1>
<ul class="nav nav-tabs">
    <li class="active"><a data-toggle="tab" href="#access_tab">Access Sample Set Data</a></li>
    <li><a data-toggle="tab" href="#search_pfr_tab">Search PFR Data</a></li>
    <li><a data-toggle="tab" href="#compounds_tab">Compounds</a></li>
    <li><a data-toggle="tab" href="#data_prf_tab">PFR Data</a></li>
    <li><a data-toggle="tab" href="#unkown_compounds_tab">Unknown Compounds</a></li>
</ul>
</header>
<div class="tab-content">
    <div id="access_tab" class="tab-pane fade in active">
        <h2>How To: Access Sample Set Data</h2>

        <p>Login into CAM. Find the sample set using ‘Find’.  Click on ‘View’ button.</p>
        <p><?php echo $this->Html->image('howto/AcessSSData_1.png', array('alt' => 'Screen shot of CAM', 'class' => 'img-responsive layer-2')); ?> <br></p>
        <p>If data has been upload for this sample set, a file name will show below 'Processed Data'. Download the file by clicking on the ‘Open’ button.  When using Chrome, the download appears on the bottom left and the file can be opened in Excel by double clicking.</p>
        <p><?php echo $this->Html->image('howto/AcessSSData_2.png', array('alt' => 'Screen shot if CAM', 'class' => 'img-responsive layer-2')); ?> </p>
    </div>
    <div id="search_pfr_tab" class="tab-pane fade">
        <h2>Search for PFR Data</h2>

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
    <div id="data_prf_tab" class="tab-pane fade">
        <h2>PFR data</h2>

        <h3>Find</h3>
        <p>All PFR staff can search the PFR compounds Database. The Search function has be designed so that the desired results can be found using a combination of search criteria.  Logical operators can be used to specifically find a given set of data.  Once the desired data set have be displayed, the data can be downloaded as an Excel file for further data processing of graphing as required. If you search on compound name CAM will first search the compounds database and add adding synonyms that are present in the Compounds table.

        <h3>Graph</h3>
        <p>Graphing data works in a similar way to the Search function. Firstly you need to use the search criteria to select the required dataset for the database.  Then the graphing options that are desired. To graph data select the values for the x and y axis then the chart type. Scatter charts are the only charts type that can take more than one set. Any other kind of chart will only search on and display what is entered in the first set. Click the <span class="buttonName">Add Set</span> button to add a Set then <span class="buttonName">add search criteria</span> to add a search input box with criteria value and logic options. When you select the pivot option the x and y axis will be automatically selected; the y axis will be set to intensity value and the x axis to whatever option you chose.</p>

        <h3>Import</h3>
        <p>Chemists can import data into the PFR compounds Database from a CSV file using this page. CSV files can be created by choosing to save an xlsx file as a CSV in Microsoft Excel. Click the <span class="buttonName">choose file</span> input and brows your computer for the CSV file. It will then load a preview of the file (the first 6 rows of data) if the loading was successful. You can then match up the columns in the database with the columns in you CSV file and click <span class="buttonName">import</span> and the data will be uploaded into the database. The filename that it came from will be recoded alongside the data in the data base so it is possible (if you made a mistake) to contact the administrator (probably Tony McGhie) and get the data removed you can also search for it in the PFR data search page </p>
        </div>
    <div id="unkown_compounds_tab" class="tab-pane fade">
        <h2>Unknown Compounds</h2>
        <h3>Add</h3>
        <p>Add an Unknown Compound, MSMS or proposed ID (one at a time)</p>

        <h3>Search</h3>
        <p>search for Unknown Compound</p>

        <h3>Edit</h3>
        <p>edit the data entered</p>
    </div>
</div>
