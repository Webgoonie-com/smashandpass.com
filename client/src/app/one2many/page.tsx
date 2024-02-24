import React from 'react'

const One2many = () => {
    return (
        <>
            <div>

                <header>
                    <div className="navbar navbar-inverse navbar-fixed-top">
                        <div className="container">
                        <div className="navbar-header">
                            <button type="button" className="navbar-toggle" data-toggle="collapse" data-target=".navbar-collapse"></button>
                            <a className="navbar-brand" href=".">Kurento Tutorial</a>
                        </div>
                        <div className="collapse navbar-collapse"
                            id="bs-example-navbar-collapse-1">
                            <ul className="nav navbar-nav navbar-right">
                            <li>
                                <a href="https://github.com/Kurento/kurento-tutorial-node/tree/master/kurento-one2many-call">
                                <span className="glyphicon glyphicon-file"></span> Source Code</a>
                            </li>
                            </ul>
                        </div>
                        </div>
                    </div>
                </header>

                <div className="container">
                <div className="page-header">
                    <h1>Tutorial 3: Video Call 1 to N with WebRTC</h1>
                    <p>
                    This web application consists on an one to many video call using
                    <a href="http://www.webrtc.org/">WebRTC</a>. In other words, this is
                    an implementation of a video broadcasting application. There are two
                    types of users in this application: 1 peer sending media (let's call
                    it <i>Presenter</i>) and N peers receiving the media of the <i>Presenter</i>
                    (let's call them <i>Viewers</i>). Thus, the <a
                        href="img/pipeline.png" data-toggle="lightbox"
                        data-title="Video Call 1 to N Media Pipeline"
                        data-footer="1 WebRtcEnpoint (Presenter) is set in SendOnly mode, and its stream is sent to N WebRtcEnpoints (Viewers), whics are set in RecvOnly mode.">Media
                        Pipeline</a> is composed by 1+N interconnected <i>WebRtcEndpoints</i>.
                    To run this demo follow these steps:
                    </p>
                    <ol>
                    <li>
                        Open this page with a browser compliant with WebRTC (Chrome,
                        Firefox).</li>
                    <li>
                        If you would like to be the <i>Presenter</i> of the communication,
                        click on <i>Presenter</i> button. There can only be one of this kind of
                        peer, and so, if the <i>Presenter</i> peer is already present, the
                        application returns an error (see the the console).
                    </li>
                    <li>
                        Grant the access to the camera and microphone. After the SDP
                        negotiation the communication should start.
                    </li>
                    <li>
                        In a different machine (or a different tab in the same browser)
                        click on <i>Viewer</i> button to see the <i>Presenter</i> stream.
                    </li>
                    <li>
                        Click on <i>Stop</i> to finish the communication. When <i>Presenter</i>
                        clicks on <i>Stop</i>, the rest of <i>Viewers</i> (if any) ends the
                        communication too.
                    </li>
                    </ol>
                </div>
                <div className="row">
                    <div className="col-md-5">
                    <div className="row">
                        <div className="col-md-12">
                        <a id="call" href="#" className="btn btn-success">
                            <span className="glyphicon glyphicon-play"></span> Presenter</a>
                        <a id="viewer" href="#" className="btn btn-primary">
                            <span className="glyphicon glyphicon-user"></span> Viewer</a>
                        <a id="terminate" href="#" className="btn btn-danger">
                            <span className="glyphicon glyphicon-stop"></span> Stop</a>
                        </div>
                    </div>
                    <br/>
                    <label className="control-label" htmlFor="console">Console</label>
                    <br />
                    <br />
                    <div id="console" className="democonsole">
                        <ul></ul>
                    </div>
                    </div>
                    <div className="col-md-7">
                    <div id="videoBig">
                        <video id="video" autoPlay width="640px" height="480px" poster="img/webrtc.png"></video>
                    </div>
                    </div>
                </div>
                </div>

                <footer>
                <div className="foot-fixed-bottom">
                    <div className="container text-center">
                    <hr/>
                    <div className="row">&copy; 2014-2015 Kurento</div>
                    <div className="row">
                        <div className="col-md-4">
                        <a href="http://www.urjc.es">
                            <img src="img/urjc.gif" alt="Universidad Rey Juan Carlos" height="50px"/>
                        </a>
                        </div>
                        <div className="col-md-4">
                        <a href="http://www.kurento.org">
                            <img src="img/kurento.png" alt="Kurento" height="50px"/>
                        </a>
                        </div>
                        <div className="col-md-4">
                        <a href="http://www.naevatec.com">
                            <img src="img/naevatec.png" alt="Naevatec" height="50px"/>
                        </a>
                        </div>
                    </div>
                    </div>
                </div>
                </footer>

            </div>
        </>
    )
}

export default One2many