# IoT-Privacy-Filter - PrivacyFence
Capstone Project IT8010 IoT Privacy Filter App Platform

<h2>Synopsis</h2>
This project develops and implements an application platform solution to mitigate the privacy risks with IoT devices that utilize recording capabilities. The design called for filtering mechanisms along with an accessible interactive user interface for a user to apply the filtration to the device traffic when necessary. The final product of the project accomplishes these goals by combining multiple hardware and software components that work in tandem to form the application platform solution.

<h2>Intro</h2>
Privacy is important for one's mental and physical well-being. Within one’s dwellings, it is important to feel safe and secure from any dangers of the world. With the advancements of IoT and SaaS platforms new modern conveniences are being delivered to consumers by the use of small Internet-connected devices. Currently, there are downsides to these conveniences. Evidence with these devices shows that the consumer's privacy is being sacrificed in exchange for convenience.  The Privacy concerns associated with IoT devices violate the consumer's right to privacy. Information that is not meant to be shared outside the home can be sent and stored in the cloud.  These problems of privacy if not addressed may become a major roadblock in the mass adoption of this technology in all markets.

<h2>Problem Statement</h2>
The Internet of Things is a recent technology that gives consumers many new modern conveniences but with the latest innovations come issues. One issue, in this case, is the invasion of the consumer's privacy. The way some IoT devices operate (essentially being a monitoring capture device working in conjunction with a cloud platform) means that for them to operate they need to be in an online Internet-connected available state 24/7. This process requires a constant feed of information to be sent to the IoT provider's cloud service from in and around the home at all times. This exchange mechanism trades the consumer’s right to privacy for beneficial services. This impact may lead to consumers not wanting to adopt this technology because they do not want to trade privacy for convenience. This not only hurts consumers but also the companies that provide these services. In this proposed project, I want to implement a device/platform solution that gives the consumer and not the service providers, control over the flow of information to vendor cloud services. The aim is to improve the consumer's right to privacy from the consumer viewpoint.

<h2>Research Questions</h2>
1.	How can we prevent the flow of information from an IoT device to Cloud device platforms?<br />
2.	How can we give control of when the consumer wants to share information within the home and when the consumer does not want to share information within the home?

<h2>Designing the IoT Filtering Solution</h2>

<h3>Application Platform Components</h3>
The application platform is comprised of three components<br />
•	Hardware Filtering Device<br />
•	Cloud Platform Service<br />
•	UI Application 

<h3>Hardware Filter</h3>
To block the flow of network traffic from a targeted device, some sort of physical hardware device will have to be placed between the device and the consumer's Internet gateway device. For this project, I have decided to use a lower-end raspberry pi to perform this function. The pi was chosen due to cost, ease of setup, and reliability. The model pi used was a Raspberry Pi Zero 2 W. This inexpensive small-sized microcomputer only contains a wireless network interface for communication. The device will have two functional purposes. The first function requires all traffic on the consumer network to be directed to the pi device first before going to the Internet gateway. Traffic will be run through a network firewall and if allowed, will be passed on to the internet gateway. The second function will be explained in the next part of the platform setup. The placement of the Pi is important because I only need to filter traffic for devices that are targeted for filtering. The Pi will take the place as the default gateway for outbound traffic from the consumer's home network. This will require a minor configuration on the consumer’s part. The home consumer will need to edit the DHCP service settings. The value of the default gateway will need to be changed to the IP network address of the Pi. Once this value is changed, off-network traffic will be directed to the pi. The Pi will then either filter the traffic based on the consumer's selections in the UI or will forward the traffic to the consumer's home Internet gateway. All return traffic from the Internet will travel straight from the consumer's gateway to the consumer device, skipping the pi.

<h3>Cloud Platform Service</h3>
Along with a physical filter device on the home consumers network, A cloud platform service will need to be implemented to give the consumer an easily accessible interface over which to manage their IoT devices and enable filtering reliably and effortlessly. For this project, I have built and configured an AWS EC2 ubuntu VM. The VM was configured with SSH and webserver services. SSH will be used in communication between the consumer network pi device and AWS server. The webserver will house the UI Application. The last portion of the configuration involves the setup of a Domain Name and SSL certification installation for basic access and security requirements to comply with today’s web security standards.

<h3>Filtering Process</h3>
Pi OS the operating system of the filter hardware device is a Linux Debian-based OS. To perform the filtering of network traffic, I chose to use the iptables firewall utility. Iptables is a popular choice for Linux and its syntax for ACL entries is straightforward which allows ease of entering and removing rules. This makes the process of automating filtering rules through simple bash shell scripts a clear choice for my application platform. Now I have chosen where I need to perform filtering and the direction. Lastly, I need to decide how I will filter traffic. I deiced to block traffic for an IoT device based on the device’s physical burned-in network address, its layer2 MAC address. I chose to filter traffic on the source MAC address because it’s a universally unique address and cannot be changed. 

<h3>Platform Backend Process</h3>
The process by which the platform operates relies on the AWS VM and Pi hardware component automated communication signaling to carry out tasks. Public key authentication was set up between the AWS and Raspberry Pi. The Pi will use Bash Shell scripts on an automated schedule to check for possible updates prompted by the user. These batch shell scripts are run using the Cron Job Scheduler tool on the raspberry pi. The Cron Scheduler is running scripts at very short intervals (every 10 seconds) to catch any changes made by the user. All communication between the Pi and AWS VM is conducted over SSH port 22. The communications are unidirectional with the Pi making all the connection attempts to AWS and not vice versa.

<h2>Development Process</h2>

<h3>Development of Bash Scripts</h3>
There are two features of the Application platform that require the AWS VM and the Pi device to work in tandem<br />

•	Network scanning – This is to find IoT devices on the user’s home network to add to the device list in the user's profile in AWS<br />
•	Filtering – Applying filtering rules to the selected IoT devices in the user's profile device list.<br />

As mentioned in the backend process section. I have created bash shell scripts to check for these signals and run jobs to accomplish these tasks. 
The workflow of the process looks like the below<br />

Consumer makes a change in UI -> Action logged by server -> Client hardware checks for changes -> Client grabs new configurations -> Applies iptables rule changes -> Action logged by client hardware<br />

I will now cover the Pi Bash Shell Scripts<br />

scanLAN.sh<br />
This script connects to AWS and copies a file called scanCheck.txt to a temp directory on the pi. This file will either contain a “0” or a “1”. If the contents contain a “0” the script exits. If the contents contain a “1”, The script will execute a network scan using the Nmap utility only checking for other devices on the local network. The results of the scan are stored in a text file called scanResults.txt and are copied back to AWS. The last actions of the script overwrite the value for scanCheck.txt on AWS to “0” and writes a timestamp and event comment to a text file called log.txt on AWS as well.<br /> 

iptablesUpdate.sh<br />
The script connects to AWS and copies a file called ruleCheck.txt to a temp directory on the pi. This file will either contain a “0” or a “1”. If the contents contain a “0” the script exits. If the contents contain a “1”, The Script will connect again to AWS and copy a file called ruleUpdates.txt to a temp directory on the pi. The file ruleUpdates.txt contains line(s) of MAC address with either an accompanying “0 “or “1”. A “0” means that the filtering of MAC addresses should be removed, and a “1” means that MAC addresses should be filtered. The lines of the file are looped through to the end applying or removing rules based on the “0” or “1” flag. After all new rule changes are applied, the iptables configuration file is saved. The last actions of the script overwrite the ruleCheck.txt on AWS to “0”, overwrites ruleUpdates.txt to a blank file, and writes a timestamp and event comment to a text file called log.txt on AWS as well.<br />

piClientCheck.sh<br />
This last bash script that ties together the client hardware and AWS service runs solely on the AWS ubuntu VM. The script is also automated running with the Cron Job Scheduler on the AWS VM. This script checks the auth.log file on the server VM for the last unique SSH connection attempt being made by the client pi hardware. The connection entry is analyzed, and an arithmetic calculation is conducted. The timestamp of the connection entry is subtracted from the current date-time of the server. If the value is less than or equal to 60 a “1” is written to the file pistatus.txt. If the value of the arithmetic is greater than 60 a “0” is written to the file. 

<h3>Storage System</h3>
The storage component of the application platform is quite simple. I originally was going to use a relational database such as MySQL but due to the simplicity of data sets my application would be working with, I decided to use a flat-file system with basic text files instead. The use of flat files also simplifies the data exchange between AWS and Pi hardware components. Next, I will explain the flat files and explain their purpose for the application platform<br /><br/>

scanCheck.txt – file contents are either a “0” or “1”. The contents let the pi hardware know if the user requested a network scan from the UI app.<br />
scanResults.txt- contains the most recent Nmap scan results<br />
ruleCheck.txt - file contents are either a “0” or “1”. The contents let the pi hardware know if the user requested filtering changes from the UI app.<br />
ruleUpdates.txt – contains a list of rule changes for the iptables firewall. Each line contains a “0” or “1” followed by a device MAC address. <br />
devices.txt – contains the list of IoT devices for the user profile. Each line contains a “0” or “1” followed by a hostname and a device MAC address.<br />
pistatus.txt – file contents are either a “0” or “1”. The contents let the UI application know if the hardware pi is on/offline.<br />
log.txt – file contents are timestamps with event comments. 

<h3>Profile & Authentication</h3>
Due to time constraints, I did not come up with a method of registering for a user account. The way the App platform functions, a single pi device would need to be tied to a UI profile account. This constraint did not limit me from developing the app without user profiles in mind. The design of the UI app includes individual profile security. The demo user has to provide authentication using a username and password to access their account. Profiles are stored in protected areas of the web app and use basic authentication for authorization to access the profile. To counter the security implications of using basic authentication, SSL certificates have been installed and all traffic to the webserver is over port 443 using the HTTPS protocol.<br /><br />

The Demo Profile Credentials<br /> 
Username: webuser01<br />
Password: Ofedis1299!<br />

<h3>Development of UI</h3>
Part of the design process for the front-end UI was coming up with a name. I have chosen the name PrivacyFence for the app. The reason for this is like a tall privacy fence that shields your property from prying eyes, my application platform will shield your privacy from IoT devices. The design of PrivacyFence went through multiple design ideas. After many challenges in creating a hybrid mobile app with ionic, I decided that the UI would be a pure web application constructed primarily in PHP. The UI can be accessed by any device with a modern web browser. The UI web address is https://privacyfence.tk. PrivacyFence is optimized for smaller mobile device screens using CSS. UI components are identifiable with intuitive buttons, recognizable icons, and simple navigation. I used the design principle of Separation of Concerns for creating the logic for the PHP pages of the app. I also used clear comments for most PHP statements for future review or edits.

<h3>UI Features</h3>
When the user first loads the web app, they are met with a splash screen that displays the application name. Next, the user is presented with a web form to provide authentication for their account. Here the user will enter their username and password to access their profile within the application. After passing authentication, the user is placed on the device page.<br /> <br/>
Next, I will explain the different controls and features within the app<br /><br/>
Device screen<br/>
This screen displays the user's stored IoT devices that can be filtered by selecting the toggle button adjacent to the hostname and mac address. Clicking the “apply filter changes” button will set flags in the ruleCheck.txt file and update ruleUpdates.txt with new filtering settings for the hardware pi. The user will also notice on this page that there is a pencil icon next to the hostname title in the device list. This icon will place the user in the edit mode of the stored device list. From here the user can remove devices they no longer need. One thing to note with edit mode, if a device is currently being filtered by the platform, it can not be removed from the list. The user must first disable filtering on the main page before the application will allow the user to remove the device.<br /><br/>
Scan screen<br />
The scan screen displays the scan results from the most current Nmap scan of the user’s local network. On this screen, the user can select which devices from the network scan to add to their device list for filtering. The “scan now” button at the bottom of the screen will set the flag in the scanCheck.txt that will tell the hardware pi to run a new Nmap scan on the user’s local network.<br /><br/>
Pi status bar<br/>
Throughout every screen in the app you can find the pi status indicator at the top of the screen. This indicator lets the user know that the pi is currently online and ready to receive updates from the UI.  If the hardware pi fails to connect over SSH within 60 seconds, the status indicator will change to offline. When the indicator displays offline, each time a screen is loaded within the app will display a JavaScript popup notifying the user of the state. This feature is important because operations within the application platform will be degraded, and no filtering can take place if the hardware pi device is offline. Once the pi reestablishes connection with the AWS platform, the indicator will change back to online. JavaScript alert popups will also cease.<br /><br/>
Log screen<br/>
The log screen displays every event transaction carried out in the application. Each transaction entry has two pieces, a timestamp of the event and a comment of what event occurred. The button at the bottom of the screen “Clear Log” will clear the log.txt file and will reset the log screen event display. 

<h2>Conclusion</h2>
I believe the final product of this project is an ambitious first step in solving some of the issues with the emergence of ubiquitous IoT devices in consumer households. The additional filtration hardware to the consumer's home internet adds a new layer of privacy that is currently needed for households in transition to smart homes.  The addition of the cloud platform and UI Application working in conjunction with the local filtering solution gives consumers an easy and hassle-free method of deciding when to filter IoT devices with privacy risks.  With my application, a user can block traffic to devices with cameras, microphones, and more. These devices can be filtered at any time and from any place all with a few clicks or taps.<br /><br />

Though this application platform solves some of the targeted concerns, I have identified a few areas that which this solution can be improved upon with additional iterations.<br />
The application platform needs more automated processes that include… <br />
•	Registration of a new user account<br />
•	Setup and configuration of the hardware filter device<br />
•	Additional filtering options including a way to schedule filtering in advance at planned dates and times <br />


