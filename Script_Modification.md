#Scripts
The idea of this section of CAM is that when more than one person needs to transform excel files into different formats (for example Summary tables to a format where it can be added to CAM or some output from CAM to a summary table). The script to do this can be added to CAM and run from there without having to install python on multiple computers and worrying about installing dependencies.

To get a Python script added to CAM you will need to contact Tony McGhie as files will have to be added to the project.

There are 3 files that you will need to send him.

1.	The script file
2.	The files containing the information about what the script does
3.	A template of how the input file should be structured (optional)

##The Script File
This should have a name that is descriptive of what it is. The file locations will be passed to the script through the command line when the script is run so to access this use:

```name, file_location_in, file_location_out = argv```

The name variable will now be the name of the file the file_location_in and file_location_out will be the location of the temporary file stored when the file was uploaded. 

Any output that is printed by the script will be added to the page after the script is run along with a download link to the now modified file.
##The Help File
This will be rendered as HTML if you do not know HTML then don’t worry just leave it as plain text just avoid using the < and > signs. If you want to use these signs use these instead < = ```&lt;``` and > = ```&gt;```

The name of the file should be: ```(the name of the script)_help.ctp``` for example ```SummaryTableConvert_dB.py_help.ctp```

##The Template File
The template file should be named (the name of the file)_template. This is just to help keep the files organised.

To add a download link to the help file add this code

```php
<?php
echo $this->Form->create('General', ['url' => 'download']);
echo $this->Form->hidden('name', ['value' => '{Name when downloading}']);
echo $this->Form->hidden('path', ['value' => 'webroot/files/{Name of File}']);
echo $this->Form->end(['label' => 'Template', 'class' => 'large-button anySizeButton green-button']);
?>
```
 
Replace the text in the {} brackets (replace the {} brackets as well) with the appropriate values


