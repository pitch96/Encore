//
//  ScannerViewController.swift
//  5StarGlobalEntertainment-TKCS
//
//  Created by chetu on 14/03/23.
//

import UIKit
import AVFoundation
import AudioToolbox

final class ScannerViewController: UIViewController {
  
    // MARK: - Variable Initializer
    var scannerModel = ScannerDetailModel()
    lazy var scannerViewModel: ScannerViewModel = {
        var scannerViewModel = ScannerViewModel()
        return scannerViewModel
    }()
    var scannedData = ScannedDetails()
    @IBOutlet weak var qrScannerView: QRScannerView!

    // MARK: - ViewDidLoad
    override func viewDidLoad() {
        super.viewDidLoad()
    }
    override var preferredStatusBarStyle: UIStatusBarStyle {
        return .lightContent
    }
    // MARK: - Create function for Calling scanner API
    override func viewWillAppear(_ animated: Bool) {
        setupQRScanner()
    }
    // MARK: - Create function for call Scanner API
    func CallScannerDetailApi(ticketNo: String){
        scannerViewModel.callScannedOrderDetailApi(ticketNo: ticketNo) {[weak self] details, isSuccess in
            if isSuccess == true{
            let message = details.message ?? DefaultValue.emptyString.rawValue
            let vc = self?.storyboard?.instantiateViewController(withIdentifier: QRDetailsViewController.identifier) as! QRDetailsViewController
            if message == AppMessage.shared.RecordFound {
                AudioServicesPlayAlertSound(SystemSoundID(kSystemSoundID_Vibrate))
                vc.ticketStatus = .guestArrived
            }else if message == AppMessage.shared.QRcodeScanned{
                vc.ticketStatus = .alreadyCheckIn
                
            }else{
                vc.ticketStatus = .wrongTicket
            }
            vc.callBack = {[weak self] in
                self?.navigationController?.popViewController(animated: false)
            }
            self?.navigationController?.pushViewController(vc, animated: true)
            }else{
                let vc = self?.storyboard?.instantiateViewController(withIdentifier: QRDetailsViewController.identifier) as! QRDetailsViewController
                vc.ticketStatus = .otherEventTicket
                vc.otherTicketmsg = details.message ?? DefaultValue.errorMsg.rawValue
                vc.callBack = {[weak self] in
                    self?.navigationController?.popViewController(animated: false)
                }
                self?.navigationController?.pushViewController(vc, animated: true)
//                let alert = UIAlertController(title: Alert.projectName, message: details.message ?? DefaultValue.errorMsg.rawValue, preferredStyle: UIAlertController.Style.alert)
//                alert.addAction(UIAlertAction(title: Alert.okTitle, style: UIAlertAction.Style.default, handler:{ action in
//                   // self?.navigationController?.popViewController(animated: true)
//                    //self?.setupQRScanner()
////                    self?.qrScannerView.configure(delegate: self!, input: .init(isBlurEffectEnabled: true))
//                     self?.qrScannerView.stopRunning()
//                    //self?.setupQRScanner()
//                        }))
//                self?.present(alert, animated: true, completion: nil)
                
            }
        }
    }
    // MARK: - Create function for set Up QR-Code Scanner
    ///create function for calling scanner view to get the QR-Code
    private func setupQRScanner() {
        switch AVCaptureDevice.authorizationStatus(for: .video) {
        case .authorized:
            setupQRScannerView()
        case .notDetermined:
            AVCaptureDevice.requestAccess(for: .video) { [weak self] granted in
                if granted {
                    DispatchQueue.main.async { [weak self] in
                        self?.setupQRScannerView()
                    }
                }
            }
        default:
            showAlert()
        }
    }
     // MARK: - Create function for Scanner View
    ///create function for set up QR-Code view and scan QR- Code
    private func setupQRScannerView() {
        qrScannerView.configure(delegate: self, input: .init(isBlurEffectEnabled: true))
        qrScannerView.startRunning()
    }
    // MARK: Create function for showing Alert Before Scanning
    private func showAlert() {
        DispatchQueue.main.asyncAfter(deadline: .now() + 0.5) { [weak self] in
            let alert = UIAlertController(title: Alert.Error, message: AppMessage.shared.CameraAccess, preferredStyle: .alert)
            alert.addAction(.init(title: Alert.okTitle, style: .default))
            self?.present(alert, animated: true)
        }
    }
// MARK: - Create funtion for DisAppear Scanner After Scan QR
    override func viewDidDisappear(_ animated: Bool) {
        super.viewDidDisappear(animated)
        qrScannerView.stopRunning()
    }

    // MARK: - Back Button Action
    /// Create Function For navigate to previous screen
    /// - Parameter sender: UIButton
    /// return :nil
    @IBAction func backButtonAction(_ sender: Any) {
            self.navigationController?.popViewController(animated: true)
      }
}

// MARK: - QRScannerViewDelegate
extension ScannerViewController: QRScannerViewDelegate {
    func qrScannerView(_ qrScannerView: QRScannerView, didFailure error: QRScannerError) {
        print(error.localizedDescription)
    }
    func qrScannerView(_ qrScannerView: QRScannerView, didSuccess code: String) {
        CallScannerDetailApi(ticketNo: code)
        debugPrint("QRCODE___________\(code)")

    }

}
