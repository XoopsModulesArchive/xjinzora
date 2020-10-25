/*
* - JINZORA | Web-based Media Streamer -  
* 
* Jinzora is a Web-based media streamer, primarily desgined to stream MP3s 
* (but can be used for any media file that can stream from HTTP). 
* Jinzora can be integrated into a CMS site, run as a standalone application, 
* or integrated into any PHP website.  It is released under the GNU GPL.
* 
* - Ressources -
* - Jinzora Author: Ross Carlson <ross@jasbone.com>
* - Web: http://www.jinzora.org
* - Documentation: http://www.jinzora.org/docs	
* - Support: http://www.jinzora.org/forum
* - Downloads: http://www.jinzora.org/downloads
* - License: GNU GPL <http://www.gnu.org/copyleft/gpl.html>
* 
* - Contributors -
* Please see http://www.jinzora.org/modules.php?op=modload&name=jz_whois&file=index
* 
* - Code Purpose -
* - Java upload applet, http send part
*
* @since 04.01.04
* @author Laurent Perrin <laurent@la-base.org>
*/

import java.io.*;

public class httpsend {

	private int current = 0;
	private int current_last = 0;
	private int current_size = 0;
	
	private int file = 0;
	private int nb_file = 0;
	private int file_last = 0;
	
	private boolean done = false;
	private boolean canceled = false;
	
	java.util.Vector file_list;
	private String dest_adr;
	private int dest_port;
	private String dest_path;
	private String dest_script;

	/**
	* Starts the task.
	*/
	public void go(java.util.Vector f_list, String d_adr, int d_port, String where, String script) {
		file_list = new java.util.Vector(f_list);
		dest_adr = d_adr;
		dest_port = d_port;
		dest_path = where;
		dest_script = script;
		final SwingWorker worker = new SwingWorker() {
			public Object construct() {
				current = 0;
				current_last = 0;
				current_size = 0;
				file = 0;
				nb_file = 0;
				file_last = 0;
				done = false;
				canceled = false;
				return new ActualTask();
			}
		};
		worker.start();
	}

	public int get_current_percent() {
		return Math.round(((float)current)/((float)current_size)*100.0f);
	}

	// returns how much was done since last call, in bytes
	public int get_done() {
		int done = current - current_last;
		current_last = current;
		return done;
	}

	// returns how many files have been sent since last call
	public int get_file_done() {
		int done = file - file_last;
		file_last = file;
		return done;
	}

	public int get_total_percent() {
		return Math.round( ((float)file) / ((float)nb_file) * 100.0f );
	}

	public void stop() {
		canceled = true;
	}

	public boolean isDone() {
		return done;
	}

	class ActualTask {
		ActualTask() {
			nb_file = file_list.size();

			// ouput stream (the socket)
			try {
				java.net.Socket outSocket = new java.net.Socket(dest_adr, dest_port);
			
				for (int i=0; i<nb_file && !canceled && !done; i++) {
					if ( send_file((File)file_list.elementAt(i),outSocket) == true ){
						file++;
						read_back(outSocket);
					} else {
						send_file((File)file_list.elementAt(i),outSocket);
					}
				}

				outSocket.close();
				done = true;

			}
			catch (java.io.IOException ioe) {
				System.err.println("java.io.IOException : " + ioe.getMessage());
			}
		}
		
		public void read_back(java.net.Socket outSocket) throws java.io.IOException {
			
			while (true) {
				while ( outSocket.getInputStream().read() != 13) {}
				if (outSocket.getInputStream().read() != 10) continue;
				
				byte[] eofd = new byte[3];
				outSocket.getInputStream().read(eofd);
				if (eofd[0] == 48 && eofd[1] == 13 && eofd[2] == 10) return;
			}
		}

		public boolean send_file(File f,java.net.Socket outSocket) {

			current_size = (int)f.length();
			current = 0;
			current_last = 0;

			String file_name = dest_path+'/'+f.getName();

			// input stream (the file)
			BufferedInputStream dis;
			try {
				dis = new BufferedInputStream(new FileInputStream(f) ,128);
			} catch (java.io.FileNotFoundException e) {return false;}

			// ouput stream (the socket)
			BufferedOutputStream out_bin;
			try {
				out_bin = new BufferedOutputStream(outSocket.getOutputStream());
			} catch (java.io.IOException e) {return false;}
			PrintWriter out = new PrintWriter(out_bin,true);

			// sending out the form stuff
			out.println("POST "+dest_script+" HTTP/1.1");
			out.println("User-Agent: Jinzora upload applet v0.1");
			out.println("Connection: Keep-Alive");
			out.println("Host: ");
			out.println("Content-Type: multipart/form-data; boundary=---------------------------20154229346572");
			out.println("Content-Length: "+Integer.toString((int)f.length()+299+file_name.length()));
			out.println();
			out.println("-----------------------------20154229346572");
			out.println("Content-Disposition: form-data; name=\"attfile\"; filename=\""+file_name+"\"");
			out.println("Content-Type: application/data");
			out.println();

			// sending up the file
			try {
				int nb_read=0;
				byte[] data = new byte[4096];
				while ((nb_read=dis.read(data,0,4096)) != -1) {
					out_bin.write(data,0,nb_read); 
					current += nb_read;
					try {Thread.sleep(10);} catch (InterruptedException e) {System.out.println("Send interrupted");}
				}
			} catch (java.io.IOException e) {return false;}

			// To say to the receiving script it's a file
			out.println();
			out.println("-----------------------------20154229346572");
			out.println("Content-Disposition: form-data; name=\"submit_upload\"");
			out.println();
			out.println("nothing");
			out.println("-----------------------------20154229346572--");
			
			// todo, send this on the last file to get a cache update
			//out.println();
			//out.println("-----------------------------20154229346572");
			//out.println("Content-Disposition: form-data; name=\"update_cache\"");
			//out.println();
			//out.println("nothing");
			//out.println("-----------------------------20154229346572--");

			return true;
		}
    }	// endof class ActualTask
} // endof class httpsend