const electron = require('electron')
const path = require('path')
const { exec } = require('child_process');



const BrowserWindow = electron.BrowserWindow
const app = electron.app
app.commandLine.appendSwitch('ignore-certificate-errors');
app.commandLine.appendSwitch('disable-web-security');
app.on('ready', () => {
  createWindow()
})

var phpServer = require('node-php-server');
const port = 9060, host = '127.0.0.1';
const serverUrl = `http://${host}:${port}`;


let mainWindow

function createWindow() {

  // Run a command for sql
exec('cmd /c "C:/pos config/xampp/mysql_start.bat"', (error, stdout, stderr) => {
  if (error) {
    console.error(`Error executing command: ${error}`);
    return;
  }

  console.log(`Command output: ${stdout}`);
});

  // Create a PHP Server
  phpServer.createServer({
    port: port,
    hostname: host,
    base: `${__dirname}/htdocs/public`,
    keepalive: false,
    open: false,
    bin: `${__dirname}/php7/php.exe`,
    router: __dirname + '/htdocs/public/index.php'
  });

  // Create the browser window.
  const {
    width,
    height
  } = electron.screen.getPrimaryDisplay().workAreaSize
  mainWindow = new BrowserWindow({
    width: 1000,
    height: 800,
    autoHideMenuBar: true
  })

  mainWindow.loadURL(`http://localhost:${port}`)

  mainWindow.webContents.once('dom-ready', function () {
    mainWindow.show()
    mainWindow.maximize();
    // mainWindow.webContents.openDevTools()
  });

  

  // Emitted when the window is closed.
  mainWindow.on('closed', function () {
    // phpServer.close();
    mainWindow = null;
  })
}

app.on('certificate-error', (event, webContents, url, error, certificate, callback) => {
  console.log('error')
  // Prevent having error
  event.preventDefault()
  // and continue
  callback(true)

})

// This method will be called when Electron has finished
// initialization and is ready to create browser windows.
// Some APIs can only be used after this event occurs.
//app.on('ready', createWindow) // <== this is extra so commented, enabling this can show 2 windows..

// Quit when all windows are closed.
app.on('window-all-closed', function () {
  // On OS X it is common for applications and their menu bar
  // to stay active until the user quits explicitly with Cmd + Q
  if (process.platform !== 'darwin') {
    // PHP SERVER QUIT
    phpServer.close();
    app.quit();
  }
})

app.on('activate', function () {
  // On OS X it's common to re-create a window in the app when the
  // dock icon is clicked and there are no other windows open.
  if (mainWindow === null) {
    createWindow()
  }
})



