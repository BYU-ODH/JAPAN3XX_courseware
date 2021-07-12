// JumpTo.cpp : implementation file
//

#include "stdafx.h"
#include "Japanese 301.h"
#include "JumpTo.h"

#ifdef _DEBUG
#define new DEBUG_NEW
#undef THIS_FILE
static char THIS_FILE[] = __FILE__;
#endif

/////////////////////////////////////////////////////////////////////////////
// JumpTo dialog


JumpTo::JumpTo(CWnd* pParent /*=NULL*/)
	: CDialog(JumpTo::IDD, pParent)
{
	//{{AFX_DATA_INIT(JumpTo)
	m_Jump = 1;
	//}}AFX_DATA_INIT
}


void JumpTo::DoDataExchange(CDataExchange* pDX)
{
	CDialog::DoDataExchange(pDX);
	//{{AFX_DATA_MAP(JumpTo)
	DDX_CBIndex(pDX, IDC_JUMP, m_Jump);
	//}}AFX_DATA_MAP
}


BEGIN_MESSAGE_MAP(JumpTo, CDialog)
	//{{AFX_MSG_MAP(JumpTo)
	ON_CBN_SELCHANGE(IDC_JUMP, OnSelchangeJump)
	//}}AFX_MSG_MAP
END_MESSAGE_MAP()

/////////////////////////////////////////////////////////////////////////////
// JumpTo message handlers

void JumpTo::OnSelchangeJump() 
{
	// TODO: Add your control notification handler code here
	UpdateData();
	AfxMessageBox("Under Construction!");
	
}