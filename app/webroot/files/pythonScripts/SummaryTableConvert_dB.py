# -*- coding: utf-8 -*-

from sys import argv
import numpy as np
import pandas as pd
import sys

name, file_location_in, file_location_out = argv

# the following script: 1) reads dataframe from a csv file; 2) re-arranges data so that rows are by component/sample;
# 4) writes the new dataframe out to new csv file.
# Data must be organised by compounds (rows) and samples (columns)
# Column1=compound name; Column 2= mass (accurate); Column3=id code; Column4=CAS number; Column5=conc units
# Column 6+ data intensity values.
# Row 1 contains a blank line with text in the first column eg 'header'
# Row 2 contains 'sample_ref' then the actual samples names from column 7
# Row 3 contains 'sample_description' then the actual sample description from column 7
# Row 4 contains 'genotype' then the actual genotype from column 7
# Row 5 contains 'tissue' then the actual tissue from column 7
# Row 6 contains 'name' 'exact_mass' 'id_conf' 'cas' 'rt' 'intensity units' then blank from column 7
# Row 7 onwards contains the data
##### Enter the location of the csv file - add double back slashes for MSWindows
FileName=file_location_in;
df=pd.read_csv(FileName, header=0)
#print df to check if all is ok
#df.ix[:,:]
#
#
# Produces a new df  ordered sample by component
# Remember to adjust the variables in the next three rows to match the loaded table
# The columns for the df_Compound need to match the incoming table
FirstSample = 6  ## enter the column number of the first sample column
#### error thrown if last sample is too large. Make sure this numer is correct  
FirstCompound = 4 ## enter the row number of the first compound row
#setup the new dataframe with the necessary column
df_byCompound = pd.DataFrame(columns=['compound','exact_mass','assigned_confid','cas', 'rt_value', 'intensity_units', 'sample_ref', 'sample_description', 'genotype', 'tissue', 'intensity_value'])
#now loop thought the input dataframe and write values into the output dataframe
loop = FirstSample
while 1==1: #process across samples
    #print df.ix[0,loop]
    try:
        for i,r in df.iterrows(): #for each row (compound) in a samples add data to the new datatable (df_byCompound)
            #print df.ix[i,0], df.ix[i,1], df.ix[i,2], df.ix[i,3]
            if i > FirstCompound: #the first rows of df that contain sample information and are loaded into the new df as below
                df_byCompound = df_byCompound.append({'compound':df.ix[i,0], 'exact_mass':df.ix[i,1], 'assigned_confid':df.ix[i,2], 'cas':df.ix[i,3], 'rt_value':df.ix[i,4],'intensity_units':df.ix[i,5], 'sample_ref':df.ix[0,loop],'sample_description':df.ix[1,loop],'genotype':df.ix[2,loop],'tissue':df.ix[3,loop],'intensity_value':df.ix[i,loop]},ignore_index=True)
    except:
        break
    loop=loop+1
###########

# Write the new dataframe to a .csv file
FileNameOut=file_location_out;
#FileNameOut = "\\\Paldfs12\\home$\\HRPTKM\\My Documents\\Data\\compounds db\\InputData\\MH8_BPA_onionPP_out.csv"
df_byCompound.to_csv(FileNameOut)
print('Conversion Successful')