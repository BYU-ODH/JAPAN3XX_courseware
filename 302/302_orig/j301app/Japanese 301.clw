; CLW file contains information for the MFC ClassWizard

[General Info]
Version=1
LastClass=CMainFrame
LastTemplate=CDialog
NewFileInclude1=#include "stdafx.h"
NewFileInclude2=#include "Japanese 301.h"
LastPage=0

ClassCount=6
Class1=CJapanese301App
Class2=CJapanese301Doc
Class3=CJapanese301View
Class4=CMainFrame

ResourceCount=2
Resource1=IDD_ABOUTBOX
Class5=CAboutDlg
Class6=JumpTo
Resource2=IDR_MAINFRAME

[CLS:CJapanese301App]
Type=0
HeaderFile=Japanese 301.h
ImplementationFile=Japanese 301.cpp
Filter=N
LastObject=CJapanese301App

[CLS:CJapanese301Doc]
Type=0
HeaderFile=Japanese 301Doc.h
ImplementationFile=Japanese 301Doc.cpp
Filter=N
LastObject=CJapanese301Doc

[CLS:CJapanese301View]
Type=0
HeaderFile=Japanese 301View.h
ImplementationFile=Japanese 301View.cpp
Filter=C
LastObject=ID_FILE_INDEX
BaseClass=CHtmlView
VirtualFilter=7VWC


[CLS:CMainFrame]
Type=0
HeaderFile=MainFrm.h
ImplementationFile=MainFrm.cpp
Filter=T
BaseClass=CFrameWnd
VirtualFilter=fWC
LastObject=ID_BUTTON_IDX




[CLS:CAboutDlg]
Type=0
HeaderFile=Japanese 301.cpp
ImplementationFile=Japanese 301.cpp
Filter=D
LastObject=CAboutDlg

[DLG:IDD_ABOUTBOX]
Type=1
Class=CAboutDlg
ControlCount=5
Control1=IDC_STATIC,static,1342177283
Control2=IDC_STATIC,static,1342308481
Control3=IDC_STATIC,static,1342308353
Control4=IDOK,button,1342373889
Control5=IDC_STATIC,static,1342308353

[MNU:IDR_MAINFRAME]
Type=1
Class=CMainFrame
Command1=ID_FILE_START
Command2=ID_FILE_INDEX
Command3=ID_APP_EXIT
Command4=ID_VIEW_TOOLBAR
Command5=ID_VIEW_STATUS_BAR
Command6=ID_HELP_HOWTO
Command7=ID_HELP_TECHSUPP
Command8=ID_APP_ABOUT
CommandCount=8

[ACL:IDR_MAINFRAME]
Type=1
Class=CMainFrame
Command1=ID_EDIT_COPY
Command2=ID_FILE_INDEX
Command3=ID_FILE_START
Command4=ID_EDIT_PASTE
Command5=ID_EDIT_UNDO
Command6=ID_EDIT_CUT
Command7=ID_NEXT_PANE
Command8=ID_PREV_PANE
Command9=ID_EDIT_COPY
Command10=ID_EDIT_PASTE
Command11=ID_EDIT_CUT
Command12=ID_EDIT_UNDO
CommandCount=12

[DLG:IDR_MAINFRAME]
Type=1
Class=JumpTo
ControlCount=2
Control1=IDC_JUMP,combobox,1344339971
Control2=IDC_STATIC,static,1342308352

[TB:IDR_MAINFRAME]
Type=1
Class=?
Command1=ID_BUTTON_GO
Command2=ID_BUTTON_IDX
Command3=ID_BUTTON_JHP
CommandCount=3

[CLS:JumpTo]
Type=0
HeaderFile=JumpTo.h
ImplementationFile=JumpTo.cpp
BaseClass=CDialog
Filter=D
VirtualFilter=dWC
LastObject=IDC_JUMP

