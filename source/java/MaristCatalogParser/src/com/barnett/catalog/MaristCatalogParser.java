/**
 * 
 */
package com.barnett.catalog;

import java.io.*;
import java.util.regex.Matcher;
import java.util.regex.Pattern;
import java.sql.*;


/**
 * @author Christopher Barnett
 *
 */
public class MaristCatalogParser {

	/**
	 * @param args
	 */
	public static void main(String[] args) {
		try {
			//File Management
			FileReader freader = new FileReader("catalog.txt");
			BufferedReader reader = new BufferedReader(freader);
			FileWriter fwriter = new FileWriter("majors.sql");
			BufferedWriter writer = new BufferedWriter(fwriter);
			FileWriter fmwriter = new FileWriter("minors.sql");
			BufferedWriter mwriter = new BufferedWriter(fmwriter);
			
			//Variables
			String line = "";
			String major = "";
			String minor = "";
			String subject = "";
			String courseNum = "";
			Pattern p;
			Matcher m;
			
			//connection shit
			Connection con = null;
			Statement state = null;
			ResultSet rs = null;
			
			String url = "jdbc:postgresql://localhost/postgres";
			String user = "postgres";
			String pass = "hotpockets";
			
			//Main Read Loop
			while((line = reader.readLine()) != null){
				//Trim the stupid double quotes
				if(line.length() > 2){
					line = line.substring(1, line.length() - 1);
				}
				p = Pattern.compile("(REQUIREMENTS)(.*)((BACHELOR)|(MAJOR))(.*)(IN\\s)");
				m = p.matcher(line);
				//Is the line a Major?
				if(m.lookingAt()){
					int end = m.end();
					major = line.substring(end, line.length());
					writer.write("-- " + major + "\n");
					
					//Major Loop, get all classes for that major
					boolean finished = false;
					while(!finished){
						line = reader.readLine();
						if(line != null){
							//Trim the stupid double quotes
							if(line.length() > 2){
								line = line.substring(1, line.length() - 1);
							}
							p = Pattern.compile("(([A-Z][A-Z][A-Z])|([A-Z][A-Z][A-Z][A-Z]))(\\s)([0-9][0-9][0-9])(.*)");
							m = p.matcher(line);
							//Find the next class
							if(m.lookingAt()){
								//Is it a 4 character subject code?
								p = Pattern.compile("([A-Z][A-Z][A-Z][A-Z])");
								m = p.matcher(line);
								if(m.lookingAt()){
									subject = m.group();
								}else{
									//Then it must be a 3 character subject code
									p = Pattern.compile("([A-Z][A-Z][A-Z])");
									m = p.matcher(line);
									m.lookingAt();
									subject = m.group();
								}
								try {
									con = DriverManager.getConnection(url, user, pass);
									/*/state = con.createStatement();
									rs = state.executeQuery("SELECT * FROM marist");
									while (rs.next()){
										System.out.println("CRN: " + rs.getString("crn"));
									}/*/
								}catch (SQLException ex){
									System.out.println("screw you buddy");
								}
								
								courseNum = line.substring(m.end() + 1, m.end() + 4);
								
								writer.write("INSERT INTO majors (course_num,subject,major_name) VALUES ('" + courseNum + "','" + subject 
										+ "','" + major + "');\n");
							} else {
								//Is this the end of the Majors?
								p = Pattern.compile("(Total Credit Requirement for Graduation)");
								m = p.matcher(line);
								if(m.lookingAt()){
									finished = true;
								}
							}
						} else {
							finished = true;
						}
					}
					writer.write("\n");
					
				}else {
					p = Pattern.compile("(REQUIREMENTS)(.*)(MINOR)(.*)(IN\\s)");
					m = p.matcher(line);
					//Is it a Minor?
					if(m.lookingAt()){
						int end = m.end();
						minor = line.substring(end, line.length());
						mwriter.write("-- " + minor + "\n");
				
						//Minor Loop, get all classes for that minor
						boolean finished = false;
						while(!finished){
							line = reader.readLine();
							if(line != null){
								//Trim the stupid double quotes
								if(line.length() > 2){
									line = line.substring(1, line.length() - 1);
								}
								p = Pattern.compile("(([A-Z][A-Z][A-Z])|([A-Z][A-Z][A-Z][A-Z]))(\\s)([0-9][0-9][0-9])(.*)");
								m = p.matcher(line);
								//Find the next class
								if(m.lookingAt()){
									//Is it a 4 character subject code?
									p = Pattern.compile("([A-Z][A-Z][A-Z][A-Z])");
									m = p.matcher(line);
									if(m.lookingAt()){
										subject = m.group();
									}else{
										//Then it must be a 3 character subject code
										p = Pattern.compile("([A-Z][A-Z][A-Z])");
										m = p.matcher(line);
										m.lookingAt();
										subject = m.group();
									}
									
									courseNum = line.substring(m.end() + 1, m.end() + 4);
									
									mwriter.write("INSERT INTO minors (course_num,subject,minor_name) VALUES ('" + courseNum + "','" + subject 
											+ "','" + minor + "');\n");
								} else {
									//Is this the end of the Minors?
									p = Pattern.compile("(Total Credit Requirement for a Minor in)");
									m = p.matcher(line);
									if(m.lookingAt()){
										finished = true;
									}
								}
							} else {
								finished = true;
							}
						}
						mwriter.write("\n");
					}
				}
			}
			//Close files
			reader.close();
			writer.flush();
			writer.close();
			mwriter.flush();
			mwriter.close();
		} catch (FileNotFoundException e) {
			// TODO Auto-generated catch block
			e.printStackTrace();
		} catch (IOException e) {
			// TODO Auto-generated catch block
			e.printStackTrace();
		}

	}

}
