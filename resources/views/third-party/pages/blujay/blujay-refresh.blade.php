@extends('third-party.layouts.admin-layout')

@section('title')
Linc | Third Party Homepage
@endsection

@section('header')
@include('third-party.components.header_no_login')
@endsection

@section('content')
<input type="hidden" id="page-context" name="page-context" value="blujay">
<div class="w-full mb-12 px-4">
    <div class="relative flex flex-col min-w-0 break-words w-full mb-6 shadow-lg rounded bg-white">
        <div class="rounded-t mb-0 px-4 py-3 border-0">
            <!-- Third Party Icon -->
            <div class="flex flex-wrap items-center">
                <div class="flex w-full h-24 px-4 max-w-full justify-center">
                    <img class="object-contain" src="{{ asset('assets/logos/blujay.png') }}" alt="">
                </div>
            </div>

            <div class="w-full my-5 flex justify-center">
                <button id="btn-blujay-refresh" class="text-white font-bold text-3xl w-64 h-64 bg-red-700 hover:bg-red-600 rounded-full shadow-md">
                    REFRESH<br>DATA
                </button>

                <div class="w-8/12 px-12">
                    <p>
                        This process will take some time, please kindly wait : <br>
                        <span class="text-red-500">*Please make sure you have already received the most updated email from blujay</span><br><br>
                        0. Authenticate registered email for Blujay Data source<br>
                        <b>michaeltenoyo.lincgroup@gmail.com</b>
                        <hr>
                        1. Crawling from registered email (michaeltenoyo.lincgroup@gmail.com) <br>
                        <b>IMPORTANT! </b>Please contact the IT Team to change the registered email that assigned to blujay adHoc "Scheduled Email" <br>
                        <hr>
                        2. Blujay Confirmation <br>
                        <b>IMPORTANT! </b>Don't leave yet! Please wait until this step for your confirmation on the recent Blujay <br>
                        <hr>
                        3. Crawling blujay attachment from gmail <br>
                        <b>IMPORTANT! </b>This process onward will take a several minutes, you can leave but keep this browser open while refresh is in progress.
                        <hr>
                        4. Database injecting : Shipment >> Load Performance >> Addcost
                    </p>
                </div>
            </div>

            <hr>

            <div class="w-full p-5 text-center">
                <div class="w-full font-bold text-xl underline">
                    REFRESH DEBUG
                </div>
                <div class="w-full">
                    Click on the big red button to start the process.
                </div>

                <div class="flex w-full my-5 p-15 rounded border-dashed border-2 border-emerald-500">
                    <!--Auth-->
                    <div class="w-4/12 text-8xl">
                        <b><span id="progress-percentage">0</span>%</b>
                        <br>
                        <span>
                            <p class="text-sm" id="progress-description">
                                Waiting for authentification...
                            </p>
                        </span>
                    </div>
                    <div class="w-8/12 text-center">
                        <div class="w-full mb-5 font-bold text-3xl">
                            FOLLOW THESE STEPS
                        </div>
                        <!--Progress Display-->
                        Please authenticate to registered email.
                        <br><br>
                        <button id="authorize-button" class="rounded p-3 bg-teal-200 hover:bg-teal-300" onclick="handleAuthClick()">
                            Authorize
                        </button>
                        <br>
                        <!-- Blujay Mail Confirmation-->
                        <div id="progress-blujay-confirmation" class="text-center my-5 hidden">
                            <p>
                                Recent data mail from Blujay : <br>
                                <span class="text-red-500">*Please confirm these are the latest mail from blujay to be injected!</span>
                                <br><br>
                                <ul id="progress-blujay-mail">
                                    <li>DD/MM/YYYY : Shipment</li>
                                    <li>DD/MM/YYYY : Load Performance</li>
                                    <li>DD/MM/YYYY : Addcost</li>
                                </ul>
                            </p>

                            <button id="inject-sql-button" class="rounded p-3 bg-teal-200 hover:bg-teal-300 my-5">
                                Continue
                            </button>
                        </div>
                        <!-- SQL Injection -->
                        <div id="progress-blujay-injecting" class="text-center my-5">
                            
                        </div>
                        
                        <script type="text/javascript">
                            /* exported gapiLoaded */
                            /* exported gisLoaded */
                            /* exported handleAuthClick */
                            /* exported handleSignoutClick */
                      
                            // TODO(developer): Set to client ID and API key from the Developer Console
                            const CLIENT_ID = '{{ env('GOOGLE_CLIENT_ID') }}';
                            const API_KEY = '{{  env('GOOGLE_API_KEY') }}';
                      
                            // Discovery doc URL for APIs used by the quickstart
                            const DISCOVERY_DOC = 'https://www.googleapis.com/discovery/v1/apis/gmail/v1/rest';
                      
                            // Authorization scopes required by the API; multiple scopes can be
                            // included, separated by spaces.
                            const SCOPES = 'https://www.googleapis.com/auth/gmail.readonly';
                      
                            let tokenClient;
                            let gapiInited = false;
                            let gisInited = false;
                      
                            document.getElementById('authorize-button').style.visibility = 'hidden';
                      
                            /**
                             * Callback after api.js is loaded.
                             */
                            function gapiLoaded() {
                              gapi.load('client', intializeGapiClient);
                            }
                      
                            /**
                             * Callback after the API client is loaded. Loads the
                             * discovery doc to initialize the API.
                             */
                            async function intializeGapiClient() {
                              await gapi.client.init({
                                apiKey: API_KEY,
                                discoveryDocs: [DISCOVERY_DOC],
                              });
                              gapiInited = true;
                              maybeEnableButtons();
                            }
                      
                            /**
                             * Callback after Google Identity Services are loaded.
                             */
                            function gisLoaded() {
                              tokenClient = google.accounts.oauth2.initTokenClient({
                                client_id: CLIENT_ID,
                                scope: SCOPES,
                                callback: '', // defined later
                              });
                              gisInited = true;
                              maybeEnableButtons();
                            }
                      
                            /**
                             * Enables user interaction after all libraries are loaded.
                             */
                            function maybeEnableButtons() {
                              if (gapiInited && gisInited) {
                                document.getElementById('authorize-button').style.visibility = 'visible';
                              }
                            }
                      
                            /**
                             *  Sign in the user upon button click.
                             */
                            function handleAuthClick() {
                              tokenClient.callback = async (resp) => {
                                if (resp.error !== undefined) {
                                  throw (resp);
                                }
                                
                                document.getElementById('authorize-button').innerText = 'Authenticated';
                                document.getElementById('authorize-button').classList.remove('bg-teal-200');
                                document.getElementById('authorize-button').classList.remove('hover:bg-teal-300');
                                document.getElementById('authorize-button').classList.add('bg-teal-300');
                                document.getElementById('authorize-button').disabled = true;
                                document.getElementById('progress-percentage').innerText = "10";
                                document.getElementById('progress-description').innerText = "Crawling recent blujay mail...";


                                await listLabels();
                              };
                      
                              if (gapi.client.getToken() === null) {
                                // Prompt the user to select a Google Account and ask for consent to share their data
                                // when establishing a new session.
                                tokenClient.requestAccessToken({prompt: 'consent'});
                              } else {
                                // Skip display of account chooser and consent dialog for an existing session.
                                tokenClient.requestAccessToken({prompt: ''});
                              }
                            }
                      
                            /**
                             *  Sign out the user upon button click.
                             */
                            function handleSignoutClick() {
                              const token = gapi.client.getToken();
                              if (token !== null) {
                                google.accounts.oauth2.revoke(token.access_token);
                                gapi.client.setToken('');
                                document.getElementById('authorize-button').innerText = 'Authorize';
                              }
                            }
                      
                          function getHeader(headers, index) {
                              var header = '';
                              $.each(headers, function(){
                                if(this.name.toLowerCase() === index.toLowerCase()){
                                  header = this.value;
                                }
                              });
                              return header;
                          }
                            /**
                             * Print all Labels in the authorized user's inbox. If no labels
                             * are found an appropriate message is printed.
                             */
                            async function listLabels() {
                              try {
                                  //START
                                  let request = await gapi.client.gmail.users.messages.list({
                                      'userId': 'me',
                                      'labelIds': 'INBOX',
                                      'maxResults': 10,
                                      'q':"after:2022/07/08"
                                  });
                      
                                  //CRAWL LAST 3 DB
                                  let foundShipment = false;
                                  let foundPerformance = false;
                                  let foundAddcost = false;
                                  
                                  //MESSAGE BREAKDOWN STEP 1
                                  request.result.messages.forEach( async(row) => {
                                      let message = await gapi.client.gmail.users.messages.get({
                                          'userId': 'me',
                                          'id': row.id
                                      });
                                      console.log(getHeader(message.result.payload.headers, 'Subject'));
                                      if(getHeader(message.result.payload.headers, 'Subject') == "Ad Hoc Report - DB SHIPMENT SBY GROUP" && !foundShipment){
                                          console.log(getHeader(message.result.payload.headers, 'Date')+" : "+getHeader(message.result.payload.headers, 'Subject'));
                                          foundShipment = true;
                                      }else if(getHeader(message.result.payload.headers, 'Subject') == "Ad Hoc Report - DB SBY GROUP" && !foundPerformance){
                                          console.log(getHeader(message.result.payload.headers, 'Date')+" : "+getHeader(message.result.payload.headers, 'Subject'));
                                          foundPerformance = true;
                                      }else if(getHeader(message.result.payload.headers, 'Subject') == "Ad Hoc Report - DB ADDCOST SBY" && !foundAddcost){
                                          console.log(getHeader(message.result.payload.headers, 'Date')+" : "+getHeader(message.result.payload.headers, 'Subject'));
                                          foundAddcost = true;
                                      }
                                  });

                                document.getElementById('progress-percentage').innerText = "20";
                                document.getElementById('progress-description').innerText = "Waiting for mail data confirmation...";
                                //END

                                  //STEP 2 - MAIL UPDATE CONFIRMATION

                              } catch (err) {
                                return;
                              }
                      
                            }
                          </script>
                          <script async defer src="https://apis.google.com/js/api.js" onload="gapiLoaded()"></script>
                          <script async defer src="https://accounts.google.com/gsi/client" onload="gisLoaded()"></script>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
