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
* - Java upload applet, UI part
*
* @since 04.01.04
* @author Laurent Perrin <laurent@la-base.org>
*/

import java.awt.*;
import java.awt.event.*;
import javax.swing.*;

public class upload extends javax.swing.JApplet implements ActionListener {

	private int total_size = 0;

	private Timer timer;
	private httpsend task;

	private JFileChooser fc;
	private JList list;
	private java.util.Vector file_list;

	private JProgressBar fileProgressBar;
	private JProgressBar totalProgressBar;

	private JTextField dest_path_Field;

	private JButton openButton, sendButton, clearButton, cancelButton;
	
	private JLabel curr_file_nameLabel;
	
	private boolean stop = false;

	// destination parameters
	private String dest_adr;
	private int dest_port = 80;
	private String dest_script;

	// i18n parameters
	private String lang_upload = "Upload";
	private String lang_add_files = "Add files...";
	private String lang_clear_list = "Clear list";
	private String lang_current_file = "Current file";
	private String lang_total_complete = "Total complete";
	private String lang_dest_path = "Destination path";
	private String lang_finished = "Upload finished!";
	private String lang_cancel = "Cancel";

	// constructor
	public upload() {

		// set up swing to look like native system controls
		try {
			UIManager.setLookAndFeel(UIManager.getSystemLookAndFeelClassName());
		}
		catch (java.lang.Exception e) {}

		// This is a hack to avoid an ugly error message in 1.1.
		getRootPane().putClientProperty("defeatSystemEventQueueCheck", Boolean.TRUE);

		// file list is empty for now
		file_list = new java.util.Vector();

	}

	public void init() {
	
		// Gets language strings from parameters
		String temp = getParameter("WORD_UPLOAD");
		if (temp != null) {
			lang_upload = temp;
		}
		temp = getParameter("WORD_ADD_FILES");
		if (temp != null) {
			lang_add_files = temp;
		}
		temp = getParameter("WORD_CLEAR_LIST");
		if (temp != null) {
			lang_clear_list = temp;
		}
		temp = getParameter("WORD_CURRENT_FILE");
		if (temp != null) {
			lang_current_file = temp;
		}
		temp = getParameter("WORD_TOTAL_COMPLETE");
		if (temp != null) {
			lang_total_complete = temp;
		}
		temp = getParameter("WORD_DEST_PATH");
		if (temp != null) {
			lang_dest_path = temp;
		}
		temp = getParameter("WORD_FINISHED");
		if (temp != null) {
			lang_finished = temp;
		}
		temp = getParameter("WORD_CANCEL");
		if (temp != null) {
			lang_cancel = temp;
		}

		// Gets webserver address, port and script from parameters
		dest_adr = getParameter("SERVER");
		if (dest_adr == null || dest_adr.equals("")) {
			System.err.println("ERROR!!! SERVER parameter is mandatory");
		}
		String dest_port_string = getParameter("PORT");
		if (dest_port_string != null) {
			dest_port = Integer.parseInt(dest_port_string);
		}
		dest_script = getParameter("SCRIPT");
		if (dest_script == null || dest_script.equals("")) {
			System.err.println("ERROR!!! SCRIPT parameter is mandatory");
		}
		
		// Gets the colors from parameters
		String bg_color = getParameter("BG_COLOR");
		if (bg_color == null || bg_color.equals("")) {
			bg_color = new String("#CCCC99");
		}
		String fg_color = getParameter("FG_COLOR");
		if (fg_color == null || fg_color.equals("")) {
			fg_color = new String("#F5F5D0");
		}
		String border_color = getParameter("BORDER_COLOR");
		if (border_color == null || border_color.equals("")) {
			border_color = new String("#000000");
		}
		String text_color = getParameter("TEXT_COLOR");
		if (text_color == null || text_color.equals("")) {
			text_color = new String("#000000");
		}
		
		// creates the open file dialog box
	  	fc = new JFileChooser();
		fc.setFileSelectionMode(JFileChooser.FILES_AND_DIRECTORIES);
		fc.setMultiSelectionEnabled(true);

		// Creates the destination path text field
		JLabel dest_label = new JLabel(lang_dest_path);
		dest_label.setForeground(Color.decode(text_color));
		dest_label.setAlignmentX(Component.LEFT_ALIGNMENT);
		dest_path_Field = new JTextField(lang_dest_path);
		dest_path_Field.setMaximumSize(new Dimension(250,22));
		dest_path_Field.setAlignmentX(Component.LEFT_ALIGNMENT);
		dest_path_Field.setBackground(Color.decode(fg_color));
		//dest_path_Field.setForeground(Color.decode(text_color));
		String param_where = getParameter("PATH");
		if (param_where != null) {
			dest_path_Field.setText(param_where);
		}
		JPanel pathPanel = new JPanel();
		pathPanel.setLayout(new BoxLayout(pathPanel, BoxLayout.PAGE_AXIS));
		pathPanel.add(dest_label);
		pathPanel.add(dest_path_Field);
		pathPanel.setOpaque(false);
		
		// Creates the file list
		list = new JList();
		//list.setForeground(Color.decode(text_color));
		list.setBackground(Color.decode(fg_color));
		JScrollPane listScroller = new JScrollPane(list);

		// Create the open button
		openButton = new JButton(lang_add_files);
		openButton.addActionListener(this);
		openButton.setBorder(BorderFactory.createCompoundBorder(BorderFactory.createLineBorder(Color.decode(border_color)),BorderFactory.createEmptyBorder(2,2,2,2)));
		openButton.setBackground(Color.decode(fg_color));
		//openButton.setForeground(Color.decode(text_color));

		// Create the send button
		sendButton = new JButton(lang_upload);
		sendButton.addActionListener(this);
		sendButton.setBorder(BorderFactory.createCompoundBorder(BorderFactory.createLineBorder(Color.decode(border_color)),BorderFactory.createEmptyBorder(2,2,2,2)));
		sendButton.setBackground(Color.decode(fg_color));
		//sendButton.setForeground(Color.decode(text_color));

		// Create the clear button
		clearButton = new JButton(lang_clear_list);
		clearButton.addActionListener(this);
		clearButton.setBorder(BorderFactory.createCompoundBorder(BorderFactory.createLineBorder(Color.decode(border_color)),BorderFactory.createEmptyBorder(2,2,2,2)));
		clearButton.setBackground(Color.decode(fg_color));
		//clearButton.setForeground(Color.decode(text_color));

		// Create the cancel button
		cancelButton = new JButton(lang_cancel);
		cancelButton.setEnabled(false);
		cancelButton.addActionListener(this);
		cancelButton.setBorder(BorderFactory.createCompoundBorder(BorderFactory.createLineBorder(Color.decode(border_color)),BorderFactory.createEmptyBorder(2,2,2,2)));
		cancelButton.setBackground(Color.decode(fg_color));
		//cancelButton.setForeground(Color.decode(text_color));

		// For layout purposes, put the buttons in a separate panel
		JPanel buttonPanel = new JPanel();
		buttonPanel.setLayout(new BoxLayout(buttonPanel, BoxLayout.LINE_AXIS));
		buttonPanel.add(openButton);
		buttonPanel.add(Box.createHorizontalStrut(2));
		buttonPanel.add(sendButton);
		buttonPanel.add(Box.createHorizontalStrut(2));
		buttonPanel.add(clearButton);
		buttonPanel.add(Box.createHorizontalStrut(2));
		buttonPanel.add(cancelButton);
		buttonPanel.setOpaque(false);
		
		// Build the lower left panel
		JPanel lowerleftPanel = new JPanel();
		lowerleftPanel.setLayout(new BoxLayout(lowerleftPanel, BoxLayout.PAGE_AXIS));
		buttonPanel.setAlignmentX(Component.LEFT_ALIGNMENT);
		lowerleftPanel.add(buttonPanel);
		curr_file_nameLabel = new JLabel("");
		curr_file_nameLabel.setAlignmentX(Component.LEFT_ALIGNMENT);
		curr_file_nameLabel.setForeground(Color.decode(text_color));
		lowerleftPanel.add(curr_file_nameLabel);
		lowerleftPanel.setOpaque(false);
		
		// Create the progress bars
		fileProgressBar = new JProgressBar();
		fileProgressBar.setMinimum(0);
		fileProgressBar.setMaximum(100);
		fileProgressBar.setStringPainted(true);
		fileProgressBar.setBackground(Color.decode(fg_color));
		fileProgressBar.setForeground(Color.decode(text_color));
		fileProgressBar.setBorder(BorderFactory.createLineBorder(Color.decode(border_color)));
		totalProgressBar = new JProgressBar();
		totalProgressBar.setMinimum(0);
		totalProgressBar.setMaximum(100);
		totalProgressBar.setStringPainted(true);
		totalProgressBar.setBackground(Color.decode(fg_color));
		totalProgressBar.setForeground(Color.decode(text_color));
		totalProgressBar.setBorder(BorderFactory.createLineBorder(Color.decode(border_color)));
		
		// For layout purposes, put the progress bars in a separate panel
		JPanel labelsPanel = new JPanel();
		labelsPanel.setLayout(new BoxLayout(labelsPanel, BoxLayout.PAGE_AXIS));
		labelsPanel.add(Box.createVerticalGlue());
		JLabel cur_f_label = new JLabel(lang_current_file);
		cur_f_label.setForeground(Color.decode(text_color));
		labelsPanel.add(cur_f_label);
		labelsPanel.add(Box.createVerticalGlue());
		JLabel total_label = new JLabel(lang_total_complete);
		total_label.setForeground(Color.decode(text_color));
		labelsPanel.add(total_label);
		labelsPanel.add(Box.createVerticalGlue());
		labelsPanel.setOpaque(false);
		JPanel barsPanel = new JPanel();
		barsPanel.setLayout(new BoxLayout(barsPanel, BoxLayout.PAGE_AXIS));
		barsPanel.add(Box.createVerticalGlue());
		barsPanel.add(fileProgressBar);
		barsPanel.add(Box.createVerticalGlue());
		barsPanel.add(totalProgressBar);
		barsPanel.add(Box.createVerticalGlue());
		barsPanel.setOpaque(false);
		JPanel progressPanel = new JPanel();
		progressPanel.setLayout(new BoxLayout(progressPanel, BoxLayout.LINE_AXIS));
		progressPanel.add(Box.createHorizontalStrut(2));
		progressPanel.add(labelsPanel);
		progressPanel.add(Box.createHorizontalStrut(2));
		progressPanel.add(barsPanel);
		progressPanel.add(Box.createHorizontalStrut(2));
		progressPanel.setOpaque(false);

		// Lower panel
		JPanel lowerPanel = new JPanel();
		lowerPanel.setLayout(new BoxLayout(lowerPanel, BoxLayout.LINE_AXIS));
		lowerPanel.add(lowerleftPanel);
		lowerPanel.add(Box.createHorizontalGlue());
		lowerPanel.add(progressPanel);
		lowerPanel.setOpaque(false);
		lowerPanel.setMaximumSize(new Dimension(100000,4000));

		// main pane
		JPanel contentPane = new JPanel();
		contentPane.setLayout(new BoxLayout(contentPane, BoxLayout.PAGE_AXIS));
		pathPanel.setAlignmentX(Component.LEFT_ALIGNMENT);
		contentPane.add(pathPanel);
		listScroller.setAlignmentX(Component.LEFT_ALIGNMENT);
		contentPane.add(listScroller);
		lowerPanel.setAlignmentX(Component.LEFT_ALIGNMENT);
		contentPane.add(lowerPanel);
		contentPane.setOpaque(true);
		contentPane.setBackground(Color.decode(bg_color));


		// Set it as the content pane.
		setContentPane(contentPane);

		// create the worker task that would actually send stuff
		task = new httpsend();

		//Create a timer to update send status every second
		timer = new Timer(1000, new ActionListener() {
			public void actionPerformed(ActionEvent evt) {
				if (stop == true) {
					task.stop();
				}				
				if (task.isDone()) {
					Toolkit.getDefaultToolkit().beep();
					timer.stop();
					sendButton.setEnabled(true);
					clearButton.setEnabled(true);
					openButton.setEnabled(true);
					cancelButton.setEnabled(false);
					fileProgressBar.setValue(0);
					fileProgressBar.setString("0%");
					totalProgressBar.setValue(0);
					totalProgressBar.setString("0%");
					getContentPane().setCursor(Cursor.getPredefinedCursor(Cursor.DEFAULT_CURSOR));
					JOptionPane.showMessageDialog(null, lang_finished);
					file_list.clear();
					list.removeAll();
					list.repaint();
					curr_file_nameLabel.setText("");
					curr_file_nameLabel.setToolTipText("");
				} else {
					fileProgressBar.setValue(task.get_current_percent());
					fileProgressBar.setString(Integer.toString(task.get_current_percent())+"% @ "+Integer.toString(task.get_done()/1024)+" kB/s");
					totalProgressBar.setValue(task.get_total_percent());
					int nb_file_done = task.get_file_done();
					for ( ; nb_file_done > 0; nb_file_done-- ) {
						file_list.remove(0);
					}
					list.setListData(file_list);
					totalProgressBar.setString(Integer.toString(task.get_total_percent())+"% (" + Integer.toString(total_size-file_list.size()+1) + "/" + Integer.toString(total_size) + ")");
					if (!file_list.isEmpty()) {
						// Limit size, so that progress bars don't resize (too much) when displaying a long name
						String file_name = ((java.io.File)file_list.get(0)).getName();
						int max_chars = file_name.length();
						if (max_chars>20) max_chars=20;
						curr_file_nameLabel.setText( lang_current_file + ": " + file_name.substring(0,max_chars) );
						curr_file_nameLabel.setToolTipText(file_name);
					}
				}
				
			}
		});

	}

	// Called everytime a button is pushed
	public void actionPerformed(ActionEvent e) {

		// Handles open button action
		if (e.getSource() == openButton) {
			// Shows the open dialog
			int returnVal = fc.showOpenDialog(this);
			if (returnVal == JFileChooser.APPROVE_OPTION) {
				// Adds selected stuff to the file list and set it as the data to be printed 
				file_list.addAll(java.util.Arrays.asList(fc.getSelectedFiles()));
				list.setListData(file_list);
			}
		}
		
		// Handles send button action
        else if (e.getSource() == sendButton) {
			total_size = file_list.size();
			getContentPane().setCursor(Cursor.getPredefinedCursor(Cursor.WAIT_CURSOR));
			sendButton.setEnabled(false);
			clearButton.setEnabled(false);
			openButton.setEnabled(false);
			cancelButton.setEnabled(true);
			task.go(file_list,dest_adr,dest_port,dest_path_Field.getText(),dest_script);
			timer.start();
			stop = false;
		}
			
		// Handles clear button action
		else if (e.getSource() == clearButton) {
			file_list.clear();
			list.removeAll();
			list.repaint();
		}
		
		else if (e.getSource() == cancelButton) {
			stop = true;
		}
	}

}